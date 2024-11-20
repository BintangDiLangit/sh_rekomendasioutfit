<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->paginate(4);
        return view('home', compact('categories', 'products'));
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $products = Product::with('category')->paginate(4, ['*'], 'page', $page);

        return response()->json([
            'html' => view('products.load-more', compact('products'))->render(),
            'hasMore' => $products->hasMorePages(),
        ]);
    }
}
