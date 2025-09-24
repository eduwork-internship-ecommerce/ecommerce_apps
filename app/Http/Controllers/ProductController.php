<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // list produk
    public function index()
    {
        $products = Product::where('is_active', true)->paginate(9);
        return view('products.index', compact('products'));
    }

    // detail produk
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }
}
