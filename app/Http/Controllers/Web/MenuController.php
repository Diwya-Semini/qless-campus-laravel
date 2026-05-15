<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('menu', compact('products'));
    }

    public function store(Request $request)
    {
        // Zero-Error Validation
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|string|max:2048', // NEW: Allow an optional URL
        ]);

        // Create the product in the database
        Product::create([
            'canteen_id' => 1,
            'item_name' => $request->item_name,
            'category' => $request->category,
            'price' => $request->price,
            'image_url' => $request->image_url, // NEW: Save the URL to the database
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('menu.index');
    }

    public function edit(Product $product)
    {
        // Laravel automatically finds the product by its ID in the URL
        return view('menu-edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|string|max:2048',
        ]);

        $product->update([
            'item_name' => $request->item_name,
            'category' => $request->category,
            'price' => $request->price,
            'image_url' => $request->image_url,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('menu.index');
    }
}