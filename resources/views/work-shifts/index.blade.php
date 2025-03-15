@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Work Shifts</h1>
    <a href="{{ route('work-shifts.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">
        Add Work Shift
    </a>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Hari</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Shift</th>
                    <th class="border border-gray-300 px-4 py-2">Jam Mulai</th>
                    <th class="border border-gray-300 px-4 py-2">Jam Selesai</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workShifts as $shift)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $shift->name_day }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $shift->name_shift }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $shift->work_start }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $shift->work_finish }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('work-shifts.show', $shift->id) }}" class="text-blue-500">Edit</a> |
                        <form id="delete-form-{{ $shift->id }}" action="{{ route('work-shifts.destroy', $shift->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $shift->id }})" class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="border border-gray-300 px-4 py-2">
                        <div class="ml-4">
                            <button onclick="toggleEmployees({{ $shift->id }})" class="text-blue-500">
                                Show/Hide Employees
                            </button>
                            <div id="employees-{{ $shift->id }}" class="mt-2" style="display: none;">
                                <table class="w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border border-gray-300 px-4 py-2">Nama Karyawan</th>
                                            <th class="border border-gray-300 px-4 py-2">Jabatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($shift->employees as $employee)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">{{ $employee->name }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $employee->position }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleEmployees(shiftId) {
        const employeesDiv = document.getElementById(`employees-${shiftId}`);
        if (employeesDiv.style.display === 'none') {
            employeesDiv.style.display = 'block';
        } else {
            employeesDiv.style.display = 'none';
        }
    }

    function confirmDelete(shiftId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form delete jika pengguna menekan "Yes"
                document.getElementById(`delete-form-${shiftId}`).submit();
            }
        });
    }
</script>
@endsection
