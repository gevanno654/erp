@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Work Shift</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('work-shifts.update', $workShift->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Gunakan method PUT untuk update -->

            <!-- Employee Dropdown -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Employee</label>
                <select name="employee_id[]" class="w-full border border-gray-300 rounded px-4 py-2" multiple>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}"
                            {{ in_array($employee->id, $workShift->employees->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $employee->name }} - {{ $employee->position }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Day Name Dropdown -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Day</label>
                <select name="name_day" class="w-full border border-gray-300 rounded px-4 py-2">
                    <option value="Senin" {{ $workShift->name_day == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ $workShift->name_day == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ $workShift->name_day == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ $workShift->name_day == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ $workShift->name_day == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ $workShift->name_day == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                </select>
            </div>

            <!-- Shift Name -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Shift Name</label>
                <input type="text" name="name_shift" class="w-full border border-gray-300 rounded px-4 py-2"
                    value="{{ $workShift->name_shift }}" placeholder="Enter Shift Name">
            </div>

            <!-- Work Start Time -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Start Time</label>
                <input type="text" id="work_start" name="work_start" class="w-full border border-gray-300 rounded px-4 py-2"
                    value="{{ $workShift->work_start }}" placeholder="Select Start Time">
            </div>

            <!-- Work Finish Time -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">End Time</label>
                <input type="text" id="work_finish" name="work_finish" class="w-full border border-gray-300 rounded px-4 py-2"
                    value="{{ $workShift->work_finish }}" placeholder="Select End Time">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
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
