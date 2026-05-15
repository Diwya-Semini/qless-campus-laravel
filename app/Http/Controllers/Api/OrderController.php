<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendOrderReceiptJob;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'canteen_id' => 'required|exists:canteens,id'
        ]);

        $queueNumber = 'Q-' . rand(100, 999);

        $order = Order::create([
            'user_id' => Auth::id(),
            'canteen_id' => $request->canteen_id,
            'queue_number' => $queueNumber,
            'status' => 'pending',
        ]);

        SendOrderReceiptJob::dispatch($order);

        return response()->json([
            'message' => 'Successfully joined the queue!',
            'data' => $order
        ], 201);
    }
}