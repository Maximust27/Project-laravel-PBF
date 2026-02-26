<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('user')->latest();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Display a listing of the user's products.
     */
    public function myProducts()
    {
        $products = Product::where('user_id', Auth::id())->latest()->paginate(10);
        return view('products.my-products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:1', // Validasi stok
            'kondisi' => 'required|in:baru,bekas',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('products', 'public');
            $validated['foto'] = $fotoPath;
        }

        Product::create($validated);

        return redirect()->route('products.my')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('user');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Check if user owns this product
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Check if user owns this product
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0', // Validasi stok
            'kondisi' => 'required|in:baru,bekas',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }
            $fotoPath = $request->file('foto')->store('products', 'public');
            $validated['foto'] = $fotoPath;
        }

        $product->update($validated);

        return redirect()->route('products.my')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if user owns this product
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete foto if exists
        if ($product->foto) {
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();

        return redirect()->route('products.my')
            ->with('success', 'Produk berhasil dihapus!');
    }
}