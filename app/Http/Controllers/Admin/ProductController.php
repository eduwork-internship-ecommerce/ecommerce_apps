<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Product::select('brand')->distinct()->pluck('brand');

        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

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
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:products|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand'       => 'nullable|string|max:255',
            'stock'       => 'nullable|integer|min:0',
            'image_url'   => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'slug', 'price', 'category_id', 'brand', 'stock', 'description']);

        // ✅ Upload ke Cloudinary
        if ($request->hasFile('image_url')) {
            try {
                $uploadResult = Cloudinary::upload(
                    $request->file('image_url')->getRealPath(),
                    [
                        'folder' => 'products',
                        'resource_type' => 'image',
                        'transformation' => [
                            'width' => 800,
                            'height' => 800,
                            'crop' => 'limit',
                            'quality' => 'auto'
                        ]
                    ]
                );

                $data['image_url'] = $uploadResult->getSecurePath(); // aman
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['image_url' => 'Gagal mengupload gambar: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        try {
            $product = Product::create($data);

            Log::info('Product created successfully', [
                'id' => $product->id,
                'name' => $product->name,
                'image_url' => $product->image_url
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan produk: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:products,slug,' . $product->id . '|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand'       => 'nullable|string|max:255',
            'stock'       => 'nullable|integer|min:0',
            'image_url'   => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'slug', 'price', 'category_id', 'brand', 'stock', 'description']);

        // ✅ Upload ulang kalau ada file baru
        if ($request->hasFile('image_url')) {
            try {
                $uploadResult = Cloudinary::upload(
                    $request->file('image_url')->getRealPath(),
                    [
                        'folder' => 'products',
                        'resource_type' => 'image',
                        'transformation' => [
                            'width' => 800,
                            'height' => 800,
                            'crop' => 'limit',
                            'quality' => 'auto'
                        ]
                    ]
                );

                $data['image_url'] = $uploadResult->getSecurePath();
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['image_url' => 'Gagal mengupload gambar: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
