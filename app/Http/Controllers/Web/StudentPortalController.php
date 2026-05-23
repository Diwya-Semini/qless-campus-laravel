<?php 

namespace App\Http\Controllers\Web; 

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StudentPortalController extends Controller
{
    public function index()
    {
        return $this->menu();
    }
    
    // Direct access to their assigned Canteen Menu
    public function menu()
    {
        $user = auth()->user();

        // Safety Catch: If the Admin hasn't assigned them a canteen yet
        if (!$user->canteen_id) {
            return view('student.unassigned'); 
        }

        // Get their specific canteen and its active products
        $canteen = \App\Models\Canteen::findOrFail($user->canteen_id);
        $products = \App\Models\Product::where('canteen_id', $canteen->id)
                                       ->where('is_available', 1)
                                       ->get();

        return view('student.menu', compact('canteen', 'products'));
    }

    // add cart to session cart
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($product_id);
        $cart = Session::get('cart', []);

        if(isset($cart[$product_id])){
            $cart[$product_id]['quantity']++;
        }else{
            $cart[$product_id] = [
                'name' => $product->item_name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image_url
            ];
        }
        Session::put('cart', $cart);
        return redirect()->route('student.menu')->with('success', 'Added to Cart!');

    }

    // view cart
    public function cart()
    {
        return view('student_portal.cart');
    }

    // checkout
    public function checkout()
    {
        $cart = Session::get('cart');
        if(!$cart) return redirect()->route('student.menu')->with('error', 'Cart is empty!');

        // transfer data to orders table and order items table
        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach($cart as $item) { $totalAmount += $item['price'] * $item['quantity']; }

            $queueNumber = Order::whereDate('created_at', today())->count() + 1;
            $ticketNumber = rand(1000, 9999);

            $order = Order::create([
                'user_id' => auth()->id(),
                'canteen_id' => 1, // Default for single campus
                'total_amount' => $totalAmount,
                'queue_number' => $queueNumber,
                'ticket_number' => $ticketNumber,
                'status' => 'pending',
            ]);

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            Session::forget('cart'); // Clear cart after success
            DB::commit();

            return redirect()->route('student.orders')->with('success', 'Order Placed!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Checkout failed.');
        }
    }

    // show order history and live ticket
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('student_portal.orders', compact('orders'));
    }

    
}