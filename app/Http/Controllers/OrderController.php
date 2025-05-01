<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['mitra', 'product'])->orderBy('order_date', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $mitras = Mitra::all();
        $products = Product::all();
        return view('orders.create', compact('mitras', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:255|unique:orders,invoice_number',
            'order_date' => 'required|date',
            'estimated_completion_date' => 'required|date|after_or_equal:order_date',
            'mitra_id' => 'required|exists:mitras,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'invoice_number' => $request->invoice_number,
            'order_date' => $request->order_date,
            'estimated_completion_date' => $request->estimated_completion_date,
            'mitra_id' => $request->mitra_id,
            'product_id' => $request->product_id,
            'quantity' => str_replace('.', '', $request->quantity),
            'total_price' => str_replace('.', '', $request->total_price),
            'status' => 'Dibuat',
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function edit(Order $order)
    {
        if (!in_array($order->status, ['Dibuat'])) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak dapat diedit karena status sudah ' . $order->status);
        }

        $mitras = Mitra::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'mitras', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        if (!in_array($order->status, ['Dibuat'])) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak dapat diperbarui karena status sudah ' . $order->status);
        }

        $request->validate([
            'invoice_number' => 'required|string|max:255|unique:orders,invoice_number,' . $order->id,
            'order_date' => 'required|date',
            'estimated_completion_date' => 'required|date|after_or_equal:order_date',
            'mitra_id' => 'required|exists:mitras,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
        ]);

        $newQuantity = str_replace('.', '', $request->quantity);
        $quantityDifference = $newQuantity - $order->quantity;

        $order->update([
            'invoice_number' => $request->invoice_number,
            'order_date' => $request->order_date,
            'estimated_completion_date' => $request->estimated_completion_date,
            'mitra_id' => $request->mitra_id,
            'product_id' => $request->product_id,
            'quantity' => $newQuantity,
            'total_price' => str_replace('.', '', $request->total_price),
            'remaining_quantity' => $order->remaining_quantity + $quantityDifference,
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        if (!in_array($order->status, ['Dibuat'])) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak dapat dihapus karena status sudah ' . $order->status);
        }

        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Ditolak' // Hapus opsi Terkirim dari manual update
        ]);

        try {
            $order->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
}
