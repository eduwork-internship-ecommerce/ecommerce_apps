<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    // Ambil kategori & brand untuk filter di form
    $categories = Category::all();
    $brands = Product::select('brand')->distinct()->pluck('brand');

    // Mulai query
    $query = Product::with('category');

    // 🔍 Search by name
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // 🎯 Filter by category
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // 🏷️ Filter by brand
    if ($request->filled('brand')) {
        $query->where('brand', $request->brand);
    }

    // Pagination (tetap simpan query agar filter tidak hilang saat pindah halaman)
    $products = $query->paginate(10)->appends($request->query());

    return view('admin.products.index', compact('products', 'categories', 'brands'));
}


    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:products',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
