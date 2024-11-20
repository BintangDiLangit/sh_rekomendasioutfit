<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // **1. Get All Products (Index)**
    public function index()
    {
        $products = Product::with('category')->orderBy('order')->paginate(20);
        $categories = Category::all();
        return view('admin.products', compact('products', 'categories'));
    }

    // **2. Create a New Product (Store)**
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'link' => 'nullable|url',
            'description' => 'nullable|string'
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // Create the product
        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    // **3. Get a Single Product (Show)**
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found');
        }

        return view('admin.products.show', compact('product'));
    }

    // **4. Update a Product (Update)**
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'link' => 'nullable|url',
            'description' => 'nullable|string'
        ]);

        // Handle file upload (if a new image is provided)
        if ($request->hasFile('image')) {
            // Delete the old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Store the new image
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // Update the product
        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    // **5. Delete a Product (Destroy)**
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found');
        }

        // Delete the image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}
