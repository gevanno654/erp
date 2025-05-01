<?php

namespace App\Http\Controllers;

use App\Models\Restock;
use App\Models\Product; // Changed from Inventory
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RestockController extends Controller
{
    public function index()
    {
        $restocks = Restock::with(['product', 'employee'])->get(); // Changed from inventory
        return view('restocks.index', compact('restocks'));
    }

    public function create()
    {
        $products = Product::all(); // Changed from inventories
        return view('restocks.create', compact('products')); // Changed variable name
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', // Changed from id_items
            'restock_amount' => 'required|integer|min:1',
        ]);

        $employee_id = Auth::user()->employee->id;

        Restock::create([
            'product_id' => $request->product_id, // Changed from id_items
            'employee_id' => $employee_id,
            'restock_amount' => $request->restock_amount,
            'date' => now(),
            'status' => 'Dalam Proses',
        ]);

        return redirect()->route('restocks.index')->with('success', 'Pengajuan restock berhasil dibuat!');
    }

    public function edit($id)
    {
        $restock = Restock::findOrFail($id);

        // Tambahkan pengecekan status
        if ($restock->status != 'Dalam Proses') {
            return redirect()->route('restocks.index')->with('error', 'Hanya bisa mengedit pengajuan dengan status "Dalam Proses"');
        }

        $products = Product::all();
        return view('restocks.edit', compact('restock', 'products'));
    }

    public function update(Request $request, $id)
    {
        $restock = Restock::findOrFail($id);

        // Tambahkan pengecekan status
        if ($restock->status != 'Dalam Proses') {
            return redirect()->route('restocks.index')->with('error', 'Hanya bisa mengupdate pengajuan dengan status "Dalam Proses"');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'restock_amount' => 'required|integer|min:1',
        ]);

        $restock->update([
            'product_id' => $request->product_id,
            'restock_amount' => $request->restock_amount,
        ]);

        return redirect()->route('restocks.index')->with('success', 'Pengajuan restock berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:Dalam Proses,Diterima,Ditolak',
                'current_stock' => 'required|numeric|min:0', // Changed to numeric for products
                'restock_amount' => 'required|integer|min:1',
                'password' => 'required|string'
            ]);

            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah!'
                ], 401);
            }

            DB::beginTransaction();

            $restock = Restock::with('product')->findOrFail($id); // Changed from inventory

            if ($restock->status !== 'Dalam Proses') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya bisa update dari status "Dalam Proses"'
                ], 422);
            }

            $restock->status = $validated['status'];
            $restock->save();

            $product = $restock->product; // Changed from inventory
            $oldStock = $product->stock;

            if ($validated['status'] === 'Diterima') {
                $product->stock += $validated['restock_amount'];
                $product->stock_updated_at = now();
                $product->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'product_data' => [ // Changed from inventory_data
                    'old_stock' => $oldStock,
                    'new_stock' => $product->stock,
                    'item_name' => $product->name
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Password salah!'], 401);
        }

        $restock = Restock::findOrFail($id);

        // Tambahkan pengecekan status
        if ($restock->status == 'Diterima') {
            return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus pengajuan dengan status "Diterima"'], 422);
        }

        $restock->delete();

        return response()->json(['success' => true, 'message' => 'Data restock berhasil dihapus!']);
    }
}
