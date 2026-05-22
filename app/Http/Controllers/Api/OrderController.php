<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceipt;

class OrderController extends Controller
{
    /**
     * Receive a new order from the Student Mobile App.
     */
    public function store(Request $request)
    {
        // 1. Validate using column names
        $request->validate([
            'canteen_id' => 'required|integer',
            'total_amount' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 2. Generate a random Queue num
            $queueNumber = 'Q-' . rand(100, 999);

            // 3. Create the order using table structure
            $order = Order::create([
                'user_id' => $request->user()->id, 
                'canteen_id' => $request->canteen_id,
                'total_amount' => $request->total_amount,
                'queue_number' => $queueNumber,
                'status' => 'pending',
            ]);

            // 4. Save the individual food items 
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully!',
                'queue_number' => $queueNumber,
                'order_id' => $order->id
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to place order.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Reqest $request){
        try{
            // get all order of the logged in user
            $orders = Order::where('user_id', $request->user()->id)
               ->with('items.product')
               ->orderBy('created_at', 'desc')
               ->get();
               
            return response()->json([
                'orders' => $orders
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to fetch orders.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}