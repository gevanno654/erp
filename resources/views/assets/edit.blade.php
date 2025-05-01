@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Edit Aset</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('assets.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name_items" class="block text-gray-700 font-medium mb-2">Nama Aset</label>
                <input type="text" name="name_items" id="name_items" value="{{ $asset->name_items }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="type_items" class="block text-gray-700 font-medium mb-2">Tipe Aset</label>
                <input type="text" name="type_items" id="type_items" value="{{ $asset->type_items }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="items_stock" class="block text-gray-700 font-medium mb-2">Jumlah Aset</label>
                <input type="number" name="items_stock" id="items_stock" value="{{ $asset->items_stock }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('assets.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg mr-2 hover:bg-gray-400 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
