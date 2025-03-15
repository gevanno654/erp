@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Add Work Shift</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('work-shifts.store') }}" method="POST">
            @csrf

            <!-- Employee Dropdown -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Employee</label>
                <select name="employee_id[]" class="w-full border border-gray-300 rounded px-4 py-2" multiple>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->position }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Day Name Dropdown -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Day</label>
                <select name="name_day" class="w-full border border-gray-300 rounded px-4 py-2">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>

            <!-- Shift Name -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Shift Name</label>
                <input type="text" name="name_shift" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Enter Shift Name">
            </div>

            <!-- Work Start Time -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Start Time</label>
                <input type="text" id="work_start" name="work_start" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Select Start Time">
            </div>

            <!-- Work Finish Time -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">End Time</label>
                <input type="text" id="work_finish" name="work_finish" class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Select End Time">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</div>

<!-- Tambahkan Flatpickr untuk jam -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#work_start", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    flatpickr("#work_finish", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
</script>

@endsection
