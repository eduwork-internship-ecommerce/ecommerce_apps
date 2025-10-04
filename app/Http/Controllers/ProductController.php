<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category');

        // 🔍 Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🏷️ Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // 📂 Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Pagination (10 produk per halaman)
        $products = $query->paginate(10)->withQueryString();

        // Ambil semua kategori & brand untuk dropdown filter
        $categories = Category::all();
        $brands = Product::select('brand')->distinct()->pluck('brand');

        return view('userPage.products.index', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('userPage.products.show', compact('product'));
    }
}
