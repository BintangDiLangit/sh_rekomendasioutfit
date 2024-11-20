<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->paginate(4);
        $seo = Seo::first();
        return view('home', compact('categories', 'products', 'seo'));
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

    public function search(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $query = Product::query();

        if ($category && $category !== 'all') {
            $query->where('category_id', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $products = $query->with('category')->get();

        $html = view('products.load-more', compact('products'))->render();

        return response()->json(['html' => $html]);
    }
}
