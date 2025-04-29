<?php

namespace App\Http\Controllers;

use App\Models\Restock;
use App\Models\Inventory;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RestockController extends Controller
{
    public function index()
    {
        // Ambil semua data restock beserta relasi inventory dan employee
        $restocks = Restock::with(['inventory', 'employee'])->get();

        // Kirim data ke view
        return view('inventories.restock-index', compact('restocks'));
    }

    public function create()
    {
        $inventories = Inventory::all();

        return view('inventories.restock-create', compact('inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_items' => 'required|exists:inventories,id',
            'restock_amount' => 'required|integer|min:1',
        ]);

        $employee_id = Auth::user()->employee->id;

        Restock::create([
            'id_items' => $request->id_items,
            'employee_id' => $employee_id,
            'restock_amount' => $request->restock_amount,
            'date' => now(),
            'status' => 'Dalam Proses',
        ]);

        return redirect()->route('restocks.index')->with('success', 'Pengajuan restock berhasil dibuat!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        // Ambil data restock berdasarkan ID
        $restock = Restock::findOrFail($id);

        // Ambil semua data inventory untuk dipilih di form
        $inventories = Inventory::all();

        // Tampilkan view edit restock
        return view('inventories.restock-edit', compact('restock', 'inventories'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:Dalam Proses,Diterima,Ditolak',
                'current_stock' => 'required|integer|min:0',
                'restock_amount' => 'required|integer|min:1',
                'password' => 'required|string'
            ]);

            // Verifikasi password
            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah!'
                ], 401);
            }

            DB::beginTransaction();

            $restock = Restock::with('inventory')->findOrFail($id);

            if ($restock->status !== 'Dalam Proses') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya bisa update dari status "Dalam Proses"'
                ], 422);
            }

            $restock->status = $validated['status'];
            $restock->save();

            $inventory = $restock->inventory;
            $oldStock = $inventory->items_stock;

            if ($validated['status'] === 'Diterima') {
                $inventory->items_stock += $validated['restock_amount'];
                $inventory->updated_stock_date = now();
                $inventory->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'inventory_data' => [
                    'old_stock' => $oldStock,
                    'new_stock' => $inventory->items_stock,
                    'item_name' => $inventory->name_items
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

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_items' => 'required|exists:inventories,id',
            'restock_amount' => 'required|integer|min:1',
        ]);

        // Ambil data restock berdasarkan ID
        $restock = Restock::findOrFail($id);

        // Update data restock
        $restock->update([
            'id_items' => $request->id_items,
            'restock_amount' => $request->restock_amount,
        ]);

        // Redirect ke halaman restock index dengan pesan sukses
        return redirect()->route('restocks.index')->with('success', 'Pengajuan restock berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        // Validasi password
        $request->validate([
            'password' => 'required|string',
        ]);

        // Cek apakah password pengguna yang sedang login benar
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Password salah!'], 401);
        }

        // Ambil data restock berdasarkan ID
        $restock = Restock::findOrFail($id);

        // Hapus data restock (soft delete)
        $restock->delete();

        // Berikan respons sukses
        return response()->json(['success' => true, 'message' => 'Data restock berhasil dihapus!']);
    }
}
