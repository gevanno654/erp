@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Tambah Produk</h1>

    <form action="{{ route('products.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok (ton)</label>
                <input type="text" name="stock" id="stock" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    oninput="formatCurrency(this)">
            </div>

            <div>
                <label for="price_per_ton" class="block text-sm font-medium text-gray-700">Harga Jual (/ton)</label>
                <input type="text" name="price_per_ton" id="price_per_ton" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    oninput="formatCurrency(this)">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                Simpan
            </button>
        </div>
    </form>
</div>

<script>
    function formatCurrency(input) {
        // Remove all non-digit characters
        let value = input.value.replace(/[^\d]/g, '');

        // Format with thousand separators
        let formattedValue = new Intl.NumberFormat('id-ID').format(value);

        // Update displayed value
        input.value = formattedValue;
    }
</script>
@endsection
