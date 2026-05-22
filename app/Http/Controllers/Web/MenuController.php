<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display the complete campus menu grid.
     */
    public function index(Request $request)
    {
        // Simply query all products in the database!
        $query = Product::query();

        // Handle the live search bar
        if ($request->has('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('category', 'asc')->get();

        return view('canteen_manager.menu.index', compact('products'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        return view('canteen_manager.menu.create');
    }

    /**
     * Store a newly created menu item in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name'   => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url', 
            'category'    => 'required|string',
        ]);

        Product::create([
            'item_name'   => $request->item_name,
            'price'       => $request->price,
            'description' => $request->description,
            'image_url'   => $request->image_url,
            'category'    => $request->category,
            'isAvailable' => $request->has('isAvailable'), 
            // Removed canteen_id entirely!
        ]);

        return redirect()->route('menu.index')->with('success', 'Dish added successfully!');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit($id)
    {
        // Just find the product directly by its ID
        $product = Product::findOrFail($id);

        return view('canteen_manager.menu.edit', compact('product'));
    }

    /**
     * Update the specified menu item in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'item_name'   => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url',
            'category'    => 'required|string',
        ]);

        $product->update([
            'item_name'   => $request->item_name,
            'price'       => $request->price,
            'description' => $request->description,
            'image_url'   => $request->image_url,
            'category'    => $request->category,
            'isAvailable' => $request->has('isAvailable'),
        ]);

        return redirect()->route('menu.index')->with('success', 'Dish updated successfully!');
    }

    /**
     * Remove the specified menu item from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('menu.index')->with('success', 'Dish deleted from catalog!');
    }
}