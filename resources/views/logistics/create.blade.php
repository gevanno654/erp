@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Tambah Logistik</h1>

    <form action="{{ route('logistics.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fleet_number" class="block text-sm font-medium text-gray-700">Nomor Armada</label>
                <input type="text" name="fleet_number" id="fleet_number" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="order_id" class="block text-sm font-medium text-gray-700">Nomor Faktur</label>
                <select name="order_id" id="order_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    onchange="updateOrderDetails(this.value)">
                    <option value="">Pilih Nomor Faktur</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}"
                            data-order-date="{{ $order->order_date->format('Y-m-d') }}"
                            data-estimated-date="{{ $order->estimated_completion_date->format('Y-m-d') }}"
                            data-mitra-id="{{ $order->mitra_id }}"
                            data-mitra-address="{{ $order->mitra->alamat }}"
                            data-product-id="{{ $order->product_id }}"
                            data-remaining-quantity="{{ $order->remaining_quantity }}">
                            {{ $order->invoice_number }} (Sisa: {{ number_format($order->remaining_quantity, 0, ',', '.') }} ton)
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="order_date" class="block text-sm font-medium text-gray-700">Tanggal Pemesanan</label>
                <input type="date" name="order_date" id="order_date" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label for="estimated_completion_date" class="block text-sm font-medium text-gray-700">Estimasi Selesai</label>
                <input type="date" name="estimated_completion_date" id="estimated_completion_date" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label for="mitra_id" class="block text-sm font-medium text-gray-700">Nama Mitra</label>
                <input type="text" name="mitra_id" id="mitra_id" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label for="destination_address" class="block text-sm font-medium text-gray-700">Alamat Tujuan</label>
                <textarea name="destination_address" id="destination_address" rows="3" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"></textarea>
            </div>

            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="product_id" id="product_id" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label for="delivered_quantity" class="block text-sm font-medium text-gray-700">Jumlah Dikirim (/Ton)</label>
                <div class="flex items-center">
                    <input type="text" name="delivered_quantity" id="delivered_quantity" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        oninput="formatCurrency(this)">
                    <span id="remaining_quantity_info" class="ml-2 text-sm text-gray-500"></span>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('logistics.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
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

    function updateOrderDetails(orderId) {
        if (!orderId) return;

        const selectedOption = document.querySelector(`#order_id option[value="${orderId}"]`);
        if (selectedOption) {
            document.getElementById('order_date').value = selectedOption.dataset.orderDate;
            document.getElementById('estimated_completion_date').value = selectedOption.dataset.estimatedDate;

            // Untuk mitra_id dan product_id, kita perlu mendapatkan nama dari database
            // Di sini kita menggunakan data yang sudah di-load sebelumnya
            const mitraName = document.querySelector(`#order_id option[value="${orderId}"]`).text.split(' - ')[1] || '';
            document.getElementById('mitra_id').value = mitraName;

            document.getElementById('destination_address').value = selectedOption.dataset.mitraAddress;

            const productName = document.querySelector(`#order_id option[value="${orderId}"]`).text.split(' - ')[2] || '';
            document.getElementById('product_id').value = productName;

            // Update info sisa jumlah
            const remainingQuantity = parseFloat(selectedOption.dataset.remainingQuantity) || 0;
            document.getElementById('remaining_quantity_info').textContent = `Sisa: ${new Intl.NumberFormat('id-ID').format(remainingQuantity)} ton`;
        }
    }
</script>
@endsection
