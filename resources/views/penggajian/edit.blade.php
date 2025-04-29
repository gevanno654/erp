@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Penggajian</h1>

    <form action="{{ route('penggajian.update', $salary) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">ID Gaji</label>
                <input type="text" value="{{ $salary->salary_id }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="text" value="{{ $salary->date->format('d/m/Y') }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                <input type="text" value="{{ $salary->employee->name }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label for="attendance_count" class="block text-sm font-medium text-gray-700">Jumlah Kehadiran</label>
                <input type="number" name="attendance_count" id="attendance_count" required min="0" max="26"
                    value="{{ $salary->attendance_count }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="incentive" class="block text-sm font-medium text-gray-700">Insentif (Rp)</label>
                <input type="text" name="incentive_display" id="incentive" required
                    value="{{ number_format($salary->incentive, 0, ',', '.') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    oninput="formatCurrency(this)">
                <!-- Input hidden untuk nilai asli -->
                <input type="hidden" name="incentive" id="incentive_hidden" value="{{ $salary->incentive }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Gaji Pokok (Rp)</label>
                <input type="text" value="{{ number_format($salary->employee->net_salary ?? 0, 0, ',', '.') }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Total Gaji (Rp)</label>
                <input type="text" value="{{ number_format($salary->total_salary, 0, ',', '.') }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('penggajian.index', $salary->month_year) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    // Format currency input
    function formatCurrency(input) {
        // Remove all non-digit characters
        let value = input.value.replace(/[^\d]/g, '');

        // Format with thousand separators
        let formattedValue = new Intl.NumberFormat('id-ID').format(value);

        // Update displayed value
        input.value = formattedValue;

        // Update hidden value (without formatting)
        document.getElementById('incentive_hidden').value = value;
    }
</script>
@endsection
