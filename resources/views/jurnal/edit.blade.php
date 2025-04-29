@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Jurnal</h1>

    <form action="{{ route('jurnal.update', $jurnal) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Input Tanggal Transaksi -->
            <div>
                <label for="transaction_date" class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                <input type="date" name="transaction_date" id="transaction_date" required
                    value="{{ $jurnal->transaction_date->format('Y-m-d') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Input Jenis Transaksi -->
            <div>
                <label for="transaction_type" class="block text-sm font-medium text-gray-700">Jenis Transaksi</label>
                <select name="transaction_type" id="transaction_type" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="Debit" {{ $jurnal->transaction_type == 'Debit' ? 'selected' : '' }}>Debit</option>
                    <option value="Kredit" {{ $jurnal->transaction_type == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                </select>
            </div>

            <!-- Input Deskripsi -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="3" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $jurnal->description }}</textarea>
            </div>

            <!-- Input Total Nominal (Dengan Format Titik) -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Total Nominal</label>
                <input type="text" name="amount_display" id="amount_display" required
                    value="{{ number_format($jurnal->amount, 0, ',', '.') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    oninput="formatCurrency(this)">

                <!-- Input Hidden untuk Nilai Asli (tanpa format) -->
                <input type="hidden" name="amount" id="amount" value="{{ $jurnal->amount }}">
            </div>

            <!-- Input Akun Debit -->
            <div>
                <label for="debit_account" class="block text-sm font-medium text-gray-700">Akun Debit</label>
                <input type="text" name="debit_account" id="debit_account" required
                    value="{{ $jurnal->debit_account }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Input Akun Kredit -->
            <div>
                <label for="credit_account" class="block text-sm font-medium text-gray-700">Akun Kredit</label>
                <input type="text" name="credit_account" id="credit_account" required
                    value="{{ $jurnal->credit_account }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('jurnal.index', $jurnal->month_year) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
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
        // Ambil nilai input
        let value = input.value.replace(/\./g, '');

        // Format dengan titik sebagai separator ribuan
        let formattedValue = new Intl.NumberFormat('id-ID').format(value);

        // Update nilai yang ditampilkan
        input.value = formattedValue;

        // Update nilai asli (tanpa format) di input hidden
        document.getElementById('amount').value = value;
    }

    // Format saat pertama kali load
    document.addEventListener('DOMContentLoaded', function() {
        formatCurrency(document.getElementById('amount_display'));
    });
</script>
@endsection
