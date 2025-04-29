@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Tambah Jurnal</h1>

    <form action="{{ route('jurnal.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <input type="hidden" name="month_year" value="{{ $monthYear }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="transaction_date" class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                <input type="date" name="transaction_date" id="transaction_date" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="transaction_type" class="block text-sm font-medium text-gray-700">Jenis Transaksi</label>
                <select name="transaction_type" id="transaction_type" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Pilih Jenis Transaksi</option>
                    <option value="Debit">Debit</option>
                    <option value="Kredit">Kredit</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="3" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Total Nominal</label>
                <input type="text" name="amount" id="amount" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    x-data=""
                    x-mask:dynamic="$money($input, '.', ',')"
                    placeholder="Rp ">
            </div>

            <div>
                <label for="debit_account" class="block text-sm font-medium text-gray-700">Akun Debit</label>
                <input type="text" name="debit_account" id="debit_account" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="credit_account" class="block text-sm font-medium text-gray-700">Akun Kredit</label>
                <input type="text" name="credit_account" id="credit_account" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('jurnal.index', $monthYear) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-mask@1.0.0/dist/alpine-mask.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.magic('money', () => {
            return (value, decimalSeparator = '.', thousandsSeparator = ',') => {
                if (typeof value === 'undefined' || value === null) {
                    return '';
                }

                // Remove all non-digit characters
                let digits = value.replace(/\D/g, '');

                // Add thousands separators
                let amount = '';
                for (let i = 0; i < digits.length; i++) {
                    if (i > 0 && (digits.length - i) % 3 === 0) {
                        amount += thousandsSeparator;
                    }
                    amount += digits[i];
                }

                return amount;
            };
        });
    });
</script>
@endpush
