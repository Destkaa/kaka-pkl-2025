<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk dengan fitur pagination dan filtering.
     * * OPTIMASI TUGAS 3:
     * - Menggunakan select() untuk menghindari loading kolom 'description' yang berat.
     * - Menggunakan paginate() untuk membatasi record yang di-load ke RAM.
     */
    public function index(Request $request): View
    {
        $products = Product::query()
            // 1. Efficiency: Hanya ambil kolom yang ditampilkan di tabel admin
            ->select(['id', 'category_id', 'name', 'price', 'stock', 'is_active', 'created_at'])
            
            // 2. Eager Loading (Nested select untuk relasi)
            ->with([
                'category:id,name', 
                'primaryImage:id,product_id,image_path'
            ])

            // Filter Pencarian
            ->when($request->search, function ($query, $search) {
                $query->search($search); 
            })
            
            // Filter Kategori
            ->when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            
            ->latest()
            ->paginate(15) // Batasi 15 item per halaman agar load cepat
            ->withQueryString();

        // Ambil data kategori untuk dropdown filter (Hanya butuh id & name)
        $categories = Category::select(['id', 'name'])
            ->active()
            ->orderBy('name')
            ->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create(): View
    {
        // Ambil kategori hanya id dan name (Efficiency)
        $categories = Category::select(['id', 'name'])->active()->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke database.
     * Menggunakan DB Transaction untuk integritas data.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $product = Product::create($request->validated());

            if ($request->hasFile('images')) {
                $this->uploadImages($request->file('images'), $product);
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product): View
    {
        // Di halaman detail, kita tidak menggunakan select() 
        // karena di sini kita memang butuh data lengkap termasuk deskripsi.
        $product->load(['category', 'images', 'orderItems']);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product): View
    {
        $categories = Category::select(['id', 'name'])->active()->orderBy('name')->get();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui data produk.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $product->update($request->validated());

            if ($request->hasFile('images')) {
                $this->uploadImages($request->file('images'), $product);
            }

            if ($request->has('delete_images')) {
                $this->deleteImages($request->delete_images);
            }

            if ($request->has('primary_image')) {
                $this->setPrimaryImage($product, $request->primary_image);
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus produk secara permanen.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Produk dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // --- Helper Methods ---

    protected function uploadImages(array $files, Product $product): void
    {
        $isFirst = $product->images()->count() === 0;

        foreach ($files as $index => $file) {
            $filename = 'product-' . $product->id . '-' . time() . '-' . $index . '.' . $file->extension();
            $path = $file->storeAs('products', $filename, 'public');

            $product->images()->create([
                'image_path' => $path,
                'is_primary' => $isFirst && $index === 0,
                'sort_order' => $product->images()->count() + $index,
            ]);
        }
    }

    protected function deleteImages(array $imageIds): void
    {
        $images = ProductImage::whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }

    protected function setPrimaryImage(Product $product, int $imageId): void
    {
        $product->images()->update(['is_primary' => false]);
        $product->images()->where('id', $imageId)->update(['is_primary' => true]);
    }
}