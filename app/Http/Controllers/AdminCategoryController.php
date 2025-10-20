<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {

        $query = Category::query();


        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('slug', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter berdasarkan status aktif/non-aktif
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }
        $categories = $query->paginate(5)->appends(request()->query());
        return view('admin.categories.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'is_active' => 'required|boolean',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'is_active' => 'required|boolean',
        ]);

        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }
public function destroy(Category $category)
    {
        // Parameter di sini menggunakan Route Model Binding (RMB).
        // Laravel secara otomatis akan mencari kategori berdasarkan ID yang diberikan
        // di route dan menyuntikkannya ke dalam variabel $category.

        try {
            // Hapus kategori dari database
            $category->delete();

            // Redirect kembali ke halaman index dengan pesan sukses
            return redirect()->route('admin.categories.index')
                             ->with('success', 'Category "' . $category->name . '" has been deleted successfully!');

        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menghapus
            return redirect()->route('admin.categories.index')
                             ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}
