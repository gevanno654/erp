@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Tambah Penggajian - {{ $monthName }}</h1>

    <form action="{{ route('penggajian.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <input type="hidden" name="month_year" value="{{ $monthYear }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="employee_id" class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                <select name="employee_id" id="employee_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Pilih Karyawan</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" data-salary="{{ $employee->net_salary ?? 0 }}">
                            {{ $employee->name }} - {{ $employee->position }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="attendance_count" class="block text-sm font-medium text-gray-700">Jumlah Kehadiran</label>
                <input type="number" name="attendance_count" id="attendance_count" required min="0" max="26"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="incentive" class="block text-sm font-medium text-gray-700">Insentif (Rp)</label>
                <input type="text" name="incentive_display" id="incentive" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    oninput="formatCurrency(this)">
                <!-- Input hidden untuk menyimpan nilai asli tanpa format -->
                <input type="hidden" name="incentive" id="incentive_hidden">
            </div>

            <div>
                <label for="base_salary" class="block text-sm font-medium text-gray-700">Gaji Pokok (Rp)</label>
                <input type="text" id="base_salary" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="0">
            </div>

            <div>
                <label for="total_salary" class="block text-sm font-medium text-gray-700">Total Gaji (Rp)</label>
                <input type="text" name="total_salary" id="total_salary" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    value="0">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('penggajian.index', $monthYear) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                Simpan
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

        // Calculate total salary
        calculateTotalSalary();
    }

    // Calculate total salary
    function calculateTotalSalary() {
        const employeeSelect = document.getElementById('employee_id');
        const baseSalary = employeeSelect.selectedOptions[0]?.dataset.salary || 0;
        const incentive = document.getElementById('incentive_hidden').value || 0;
        const totalSalary = parseInt(baseSalary) + parseInt(incentive);

        document.getElementById('base_salary').value = new Intl.NumberFormat('id-ID').format(baseSalary);
        document.getElementById('total_salary').value = new Intl.NumberFormat('id-ID').format(totalSalary);
    }

    // Event listeners
    document.getElementById('employee_id').addEventListener('change', calculateTotalSalary);
    document.getElementById('incentive').addEventListener('input', calculateTotalSalary);

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotalSalary();
    });
</script>
@endsection
