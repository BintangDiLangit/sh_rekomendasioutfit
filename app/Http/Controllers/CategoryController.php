<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // **1. Get All Categories (Index)**
    public function index()
    {
        $categories = Category::all(); // Fetch all categories
        return view('admin.categories', compact('categories'));
    }

    // **2. Create a New Category (Store)**
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category = Category::create($validatedData); // Create new category
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    // **3. Get a Single Category (Show)**
    public function show($id)
    {
        $category = Category::find($id); // Find category by ID

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    // **4. Update a Category (Update)**
    public function update(Request $request, $id)
    {
        $category = Category::find($id); // Find category by ID

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Category not found!');
        }

        $validatedData = $request->validate([
            'category_name' => 'sometimes|required|string|max:255',
        ]);

        $category->update($validatedData); // Update category

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    // **5. Delete a Category (Destroy)**
    public function destroy($id)
    {
        $category = Category::find($id); // Find category by ID

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Category not found!');
        }

        $category->delete(); // Delete category
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
