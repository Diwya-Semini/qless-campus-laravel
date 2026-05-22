<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Start a strict database transaction
        DB::beginTransaction();

        try {
            // 1. Generate the daily queue and secure ticket number
            // Counts how many orders were placed today and adds 1 for the queue position
            $queueNumber = Order::whereDate('created_at', today())->count() + 1; 
            $ticketNumber = rand(1000, 9999); 

            // 2. Create the Main Order (The Receipt)
            $order = Order::create([
                'user_id'      => auth()->id(),
                'canteen_id'   => $request->canteen_id ?? 1, // Fallback to 1 if single tenant
                'total_amount' => $request->total_amount,
                'queue_number' => $queueNumber,
                'ticket_number'=> $ticketNumber,
                'status'       => 'pending',
            ]);

            // 3. Loop through the Flutter Cart and save the individual items
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'subtotal'   => $item['subtotal'],
                ]);
            }

            // 4. Commit the transaction (Saves everything permanently)
            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully!',
                'order'   => $order
            ], 201);

        } catch (\Exception $e) {
            // If ANYTHING fails, delete the partial data to prevent errors
            DB::rollBack();
            
            return response()->json([
                'message' => 'Failed to process checkout.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}