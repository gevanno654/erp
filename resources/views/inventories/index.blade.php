@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Daftar Inventories</h1>

        <!-- Tabel Inventories -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Item</th>
                        <th class="px-4 py-3">Tipe Item</th>
                        <th class="px-4 py-3">Stok Item</th>
                        <th class="px-4 py-3">Tanggal Pembaruan Stok</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($inventories as $index => $inventory)
                        <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $inventory->name_items }}</td>
                            <td class="px-4 py-3">{{ $inventory->type_items }}</td>
                            <td class="px-4 py-3">{{ $inventory->items_stock }}</td>
                            <td class="px-4 py-3">{{ $inventory->updated_stock_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
