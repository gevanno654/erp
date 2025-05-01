@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Tambah Pesanan</h1>

    <form action="{{ route('orders.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="invoice_number" class="block text-sm font-medium text-gray-700">Nomor Faktur</label>
                <input type="text" name="invoice_number" id="invoice_number" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="{{ old('invoice_number') }}">
                @error('invoice_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="order_date" class="block text-sm font-medium text-gray-700">Tanggal Pemesanan</label>
                <div class="flex">
                    <input type="date" name="order_date" id="order_date" required
                        class="mt-1 block w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('order_date') }}">
                    <button type="button" onclick="document.getElementById('order_date').value = '{{ date('Y-m-d') }}'"
                        class="mt-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md transition duration-200">
                        Hari Ini
                    </button>
                @error('order_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                </div>
            </div>

            <div>
                <label for="estimated_completion_date" class="block text-sm font-medium text-gray-700">Estimasi Selesai</label>
                <input type="date" name="estimated_completion_date" id="estimated_completion_date" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="{{ old('estimated_completion_date') }}">
                @error('estimated_completion_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="mitra_id" class="block text-sm font-medium text-gray-700">Nama Mitra</label>
                <select name="mitra_id" id="mitra_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="{{ old('mitra_id') }}">
                    <option value="">Pilih Mitra</option>
                    @foreach($mitras as $mitra)
                        <option value="{{ $mitra->id }}">{{ $mitra->nama_mitra }}</option>
                    @endforeach
                </select>
                @error('mitra_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <select name="product_id" id="product_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="{{ old('product_id') }}">
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price_per_ton }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah (/Ton)</label>
                <input type="text" name="quantity" id="quantity" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    oninput="formatCurrency(this); calculateTotalPrice()"
                    value="{{ old('quantity') }}">
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="total_price" class="block text-sm font-medium text-gray-700">Total Harga</label>
                <input type="text" name="total_price_formatted" id="total_price" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    readonly>
                <input type="hidden" name="total_price" id="total_price_raw">
                @error('total_price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
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

    function calculateTotalPrice() {
        const productSelect = document.getElementById('product_id');
        const quantity = document.getElementById('quantity').value.replace(/[^\d]/g, '') || 0;
        const pricePerTon = productSelect.selectedOptions[0]?.dataset.price || 0;
        const totalPrice = parseInt(quantity) * parseInt(pricePerTon);

        // Tampilkan dengan format
        document.getElementById('total_price').value = new Intl.NumberFormat('id-ID').format(totalPrice);

        // Simpan nilai asli tanpa format
        document.getElementById('total_price_raw').value = totalPrice;
    }

    // Event listeners
    document.getElementById('product_id').addEventListener('change', calculateTotalPrice);
    document.getElementById('quantity').addEventListener('input', calculateTotalPrice);
</script>
@endsection
