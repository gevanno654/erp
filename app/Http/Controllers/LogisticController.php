<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\Order;
use Illuminate\Http\Request;

class LogisticController extends Controller
{
    public function index()
    {
        $logistics = Logistic::with(['order', 'mitra', 'product'])
            ->orderBy('departure_time', 'desc')
            ->get();
        return view('logistics.index', compact('logistics'));
    }

    public function create()
    {
        $orders = Order::where('status', 'Diproses')
            ->where('remaining_quantity', '>', 0)
            ->with(['mitra', 'product'])
            ->get();
        return view('logistics.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fleet_number' => 'required|string|max:255',
            'order_id' => 'required|exists:orders,id',
            'delivered_quantity' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($request->delivered_quantity > $order->remaining_quantity) {
            return back()->with('error', 'Jumlah dikirim melebihi sisa jumlah pesanan.');
        }

        $logistic = Logistic::create([
            'fleet_number' => $request->fleet_number,
            'order_id' => $order->id,
            'order_date' => $order->order_date,
            'estimated_completion_date' => $order->estimated_completion_date,
            'mitra_id' => $order->mitra_id,
            'destination_address' => $order->mitra->alamat,
            'product_id' => $order->product_id,
            'delivered_quantity' => str_replace('.', '', $request->delivered_quantity),
            'departure_time' => now(),
            'status' => 'Dikirim',
        ]);

        // Update remaining quantity in order
        $order->remaining_quantity -= $logistic->delivered_quantity;
        $order->status = 'Diproses'; // Pastikan status tetap Diproses
        $order->save();

        return redirect()->route('logistics.index')->with('success', 'Data logistik berhasil ditambahkan.');
    }

    public function edit(Logistic $logistic)
    {
        if (!in_array($logistic->status, ['Dikirim'])) {
            return redirect()->route('logistics.index')->with('error', 'Data logistik tidak dapat diedit karena status sudah ' . $logistic->status);
        }

        return view('logistics.edit', compact('logistic'));
    }

    public function update(Request $request, Logistic $logistic)
    {
        if (!in_array($logistic->status, ['Dikirim'])) {
            return redirect()->route('logistics.index')->with('error', 'Data logistik tidak dapat diperbarui karena status sudah ' . $logistic->status);
        }

        $request->validate([
            'fleet_number' => 'required|string|max:255',
            'delivered_quantity' => 'required|numeric|min:0',
        ]);

        $newDeliveredQuantity = str_replace('.', '', $request->delivered_quantity);
        $order = $logistic->order;

        // Validasi jumlah yang dikirim tidak melebihi sisa + jumlah sebelumnya
        $maxAllowed = $order->remaining_quantity + $logistic->delivered_quantity;
        if ($newDeliveredQuantity > $maxAllowed) {
            return back()->with('error', 'Jumlah dikirim melebihi sisa jumlah pesanan. Maksimal yang bisa dikirim: ' . number_format($maxAllowed, 0, ',', '.'));
        }

        // Hitung selisih antara jumlah baru dan lama
        $quantityDifference = $newDeliveredQuantity - $logistic->delivered_quantity;

        // Update remaining quantity di order
        $order->remaining_quantity -= $quantityDifference;
        $order->save();

        // Update logistic
        $logistic->update([
            'fleet_number' => $request->fleet_number,
            'delivered_quantity' => $newDeliveredQuantity,
        ]);

        return redirect()->route('logistics.index')->with('success', 'Data logistik berhasil diperbarui.');
    }

    public function destroy(Logistic $logistic)
    {
        if (!in_array($logistic->status, ['Dikirim'])) {
            return redirect()->route('logistics.index')->with('error', 'Data logistik tidak dapat dihapus karena status sudah ' . $logistic->status);
        }

        // Kembalikan jumlah yang dikirim ke sisa pesanan
        $order = $logistic->order;
        $order->remaining_quantity += $logistic->delivered_quantity;
        $order->save();

        $logistic->delete();
        return redirect()->route('logistics.index')->with('success', 'Data logistik berhasil dihapus.');
    }

    public function completeDelivery(Logistic $logistic)
    {
        if ($logistic->status !== 'Dikirim') {
            return redirect()->route('logistics.index')->with('error', 'Pengiriman sudah selesai.');
        }

        $logistic->delivered_time = now();

        // Tentukan status berdasarkan estimasi selesai
        // Dianggap terlambat hanya jika delivered_time LEBIH BESAR dari estimated_completion_date
        // (tanggal sama masih dianggap tepat waktu)
        if ($logistic->delivered_time->gt($logistic->estimated_completion_date->endOfDay())) {
            $logistic->status = 'Terkirim Late';
        } else {
            $logistic->status = 'Terkirim Ontime';
        }

        $logistic->save();

        // Update status order hanya jika semua logistik sudah selesai
        $order = $logistic->order;
        $allLogisticsCompleted = $order->logistics()->where('status', 'Dikirim')->doesntExist();

        if ($allLogisticsCompleted) {
            // Cari status logistik yang paling akhir (terlambat)
            $latestLogistic = $order->logistics()
                ->orderBy('delivered_time', 'desc')
                ->first();

            $order->status = $latestLogistic->status;
            $order->save();
        }

        return redirect()->route('logistics.index')->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}
