<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Carbon\Carbon;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_items' => 'required|string|max:255',
            'type_items' => 'required|string|max:255',
            'items_stock' => 'required|integer|min:0',
        ]);

        Asset::create([
            'name_items' => $request->name_items,
            'type_items' => $request->type_items,
            'items_stock' => $request->items_stock,
            'updated_stock_date' => Carbon::now(),
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_items' => 'required|string|max:255',
            'type_items' => 'required|string|max:255',
            'items_stock' => 'required|integer|min:0',
        ]);

        $asset = Asset::findOrFail($id);
        $asset->update([
            'name_items' => $request->name_items,
            'type_items' => $request->type_items,
            'items_stock' => $request->items_stock,
            'updated_stock_date' => Carbon::now(),
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $assetName = $asset->name_items;
        $asset->delete();

        return redirect()->route('assets.index')->with('success', "Asset '{$assetName}' berhasil dihapus!");
    }
}
