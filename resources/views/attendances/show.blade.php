@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Absensi</h1>

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Pilih Karyawan -->
            <div class="mb-4">
                <label for="employee_id" class="block text-sm font-semibold text-gray-700">Pilih Karyawan</label>
                <select name="employee_id" id="employee_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Grid untuk Tanggal, Check-In, dan Check-Out -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tanggal Absensi -->
                <div>
                    <label for="date" class="block text-sm font-semibold text-gray-700">Tanggal Absensi</label>
                    <input type="date" name="date" id="date" value="{{ $attendance->date }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Waktu Check-In -->
                <div>
                    <label for="check_in" class="block text-sm font-semibold text-gray-700">Waktu Check-In</label>
                    <input type="text" name="check_in" id="check_in" value="{{ date('H:i', strtotime($attendance->check_in)) }}" class="timepicker mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Waktu Check-Out -->
                <div>
                    <label for="check_out" class="block text-sm font-semibold text-gray-700">Waktu Check-Out</label>
                    <input type="text" name="check_out" id="check_out" value="{{ $attendance->check_out ? date('H:i', strtotime($attendance->check_out)) : '' }}" class="timepicker mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>

            <!-- Status Absensi -->
            <div class="mt-4">
                <label for="status" class="block text-sm font-semibold text-gray-700">Status Absensi</label>
                <select name="status" id="status" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Hadir" {{ $attendance->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Absen" {{ $attendance->status == 'Absen' ? 'selected' : '' }}>Absen</option>
                    <option value="Sakit" {{ $attendance->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Izin" {{ $attendance->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                </select>
            </div>

            <!-- Durasi Kerja -->
            <div class="mt-4">
                <label for="worked_time" class="block text-sm font-semibold text-gray-700">Durasi Kerja</label>
                <input type="text" name="worked_time" id="worked_time" value="{{ $attendance->worked_time }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm bg-gray-100 focus:ring-indigo-500 focus:border-indigo-500" readonly>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    Update Absensi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script untuk Flatpickr dan Hitung Durasi Kerja -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        const checkIn = document.getElementById('check_in');
        const checkOut = document.getElementById('check_out');
        const workedTime = document.getElementById('worked_time');

        function calculateWorkedTime() {
            if (checkIn.value && checkOut.value) {
                const checkInTime = new Date(`1970-01-01T${checkIn.value}:00`);
                const checkOutTime = new Date(`1970-01-01T${checkOut.value}:00`);
                const diff = Math.abs(checkOutTime - checkInTime);
                const hours = Math.floor(diff / 3600000);
                const minutes = Math.floor((diff % 3600000) / 60000);
                workedTime.value = `${hours} jam ${minutes} menit`;
            } else {
                workedTime.value = '';
            }
        }

        checkIn.addEventListener('change', calculateWorkedTime);
        checkOut.addEventListener('change', calculateWorkedTime);
    });
</script>
@endsection
