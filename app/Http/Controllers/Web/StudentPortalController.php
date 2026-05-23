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
    public function menu(Request $request)
    {
        $user = auth()->user();
        
        // 1. Start the base query: Only get available food for THIS student's campus
        $query = Product::where('canteen_id', $user->canteen_id)
                        ->where('is_available', 1);

        // 2. Apply Search Filter (if they typed something)
        if ($request->filled('search')) {
            $query->where('item_name', 'LIKE', '%' . $request->search . '%');
        }

        // 3. Apply Category Filter (if they clicked a filter pill)
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        // 4. Finally, fetch the filtered results from the database
        $products = $query->get();
        
        // Count items in cart for the floating bar
        $itemCount = collect(session()->get('cart', []))->sum('quantity');

        // Pass the current filters back to the view so the UI remembers what was clicked
        $currentCategory = $request->category ?? 'All';
        $currentSearch = $request->search ?? '';

        return view('student.menu', compact('products', 'itemCount', 'currentCategory', 'currentSearch'));
    }

    // add cart to session cart
    // 1. ADD TO SESSION CART (No Database yet!)
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // If item is already in cart, just add to the quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Otherwise, add the new item
            $cart[$id] = [
                "name" => $product->item_name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_url
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', $product->item_name . ' added to your cart!');
    }

    // 2. VIEW THE CART PAGE
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('student.cart', compact('cart'));
    }

    // 3. THE FINAL CHECKOUT (This is where the DB Transaction goes!)
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        $user = auth()->user();
        $totalAmount = 0;
        foreach($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // The 10/10 Flex: Database Transaction
        DB::transaction(function () use ($cart, $user, $totalAmount) {
            // Create the Order
            $order = Order::create([
                'user_id' => $user->id,
                'canteen_id' => $user->canteen_id,
                'total_amount' => $totalAmount,
                'status' => 'pending'
            ]);

            // Create the Order Items
            foreach($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
        });

        // Clear the cart after a successful order
        session()->forget('cart');
        return redirect()->route('student.menu')->with('success', 'Order sent to the kitchen!');
    }

    // show order history and live ticket
    // 4. VIEW ORDER HISTORY
    public function history()
    {
        $user = auth()->user();

        // Fetch all orders for this specific student, ordered by newest first!
        $orders = Order::with(['items.product'])
                       ->where('user_id', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('student.orders', compact('orders'));
    }

    
}