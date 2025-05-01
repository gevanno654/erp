<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'stock' => 'required|numeric|min:0',
            'price_per_ton' => 'required|numeric|min:0',
        ]);

        // Format angka (hapus titik jika ada)
        $stock = str_replace('.', '', $request->stock);
        $pricePerTon = str_replace('.', '', $request->price_per_ton);

        Product::create([
            'name' => $request->name,
            'stock' => $stock,
            'price_per_ton' => $pricePerTon,
            'stock_updated_at' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'price_per_ton' => 'required|numeric|min:0',
        ]);

        // Format angka (hapus titik jika ada)
        $pricePerTon = str_replace('.', '', $request->price_per_ton);

        $product->update([
            'name' => $request->name,
            'price_per_ton' => $pricePerTon,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
