@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Logistik</h1>

    <form action="{{ route('logistics.update', $logistic->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fleet_number" class="block text-sm font-medium text-gray-700">Nomor Armada</label>
                <input type="text" name="fleet_number" id="fleet_number" required value="{{ $logistic->fleet_number }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Faktur</label>
                <input type="text" value="{{ $logistic->order->invoice_number }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Pemesanan</label>
                <input type="text" value="{{ $logistic->order_date->format('d/m/Y') }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Estimasi Selesai</label>
                <input type="text" value="{{ $logistic->estimated_completion_date->format('d/m/Y') }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Mitra</label>
                <input type="text" value="{{ $logistic->mitra->nama_mitra }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat Tujuan</label>
                <textarea rows="3" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">{{ $logistic->destination_address }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" value="{{ $logistic->product->name }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label for="delivered_quantity" class="block text-sm font-medium text-gray-700">Jumlah Dikirim (/Ton)</label>
                <input type="text" name="delivered_quantity" id="delivered_quantity" required
                    value="{{ number_format($logistic->delivered_quantity, 0, ',', '.') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    oninput="formatCurrency(this)">
                <div class="mt-2 space-y-1">
                    <p class="text-sm text-gray-600">Jumlah sebelumnya: {{ number_format($logistic->delivered_quantity, 0, ',', '.') }} ton</p>
                    <p class="text-sm text-gray-600">Sisa saat ini: {{ number_format($logistic->order->remaining_quantity, 0, ',', '.') }} ton</p>
                    <p class="text-sm font-medium text-gray-700">Maksimal yang bisa dikirim: {{ number_format($logistic->order->remaining_quantity + $logistic->delivered_quantity, 0, ',', '.') }} ton</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Waktu Keberangkatan</label>
                <input type="text" value="{{ $logistic->departure_time->format('d/m/Y H:i') }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Waktu Terkirim</label>
                <input type="text" value="{{ $logistic->delivered_time ? $logistic->delivered_time->format('d/m/Y H:i') : '-' }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('logistics.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                Simpan Perubahan
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
