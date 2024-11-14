<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('product_number', 'desc')
            ->paginate(4); // Show first 4 items (2 rows)

        return view('home', compact('products'));
    }

    public function loadMore(Request $request)
    {
        $page = $request->page ?? 1;
        $products = Product::orderBy('product_number', 'desc')
            ->paginate(4, ['*'], 'page', $page);

        if ($request->ajax()) {
            $view = view('products.load-more', compact('products'))->render();

            return response()->json([
                'html' => $view,
                'hasMore' => $products->hasMorePages(),
                'nextPage' => $products->currentPage() + 1
            ]);
        }

        return redirect()->route('home');
    }
}
