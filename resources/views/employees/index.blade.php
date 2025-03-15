@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Employees</h1>
    <a href="{{ route('employees.create-account') }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">Add Employee</a>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($employees as $employee)
        <div class="bg-white p-6 rounded-lg shadow-md relative cursor-pointer hover:shadow-lg transition duration-300"
             onclick="window.location='{{ route('employees.show', $employee->id) }}'">

            <!-- Dropdown Button -->
            <div class="absolute top-2 right-2">
                <button onclick="toggleDropdown(event, 'dropdown-{{ $employee->id }}')" class="text-gray-600 hover:text-gray-900">
                    &#x22EE;
                </button>
                <!-- Dropdown Menu -->
                <div id="dropdown-{{ $employee->id }}" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-300 rounded shadow-md">
                    <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDeletion(event, '{{ $employee->id }}')" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Hapus</button>
                    </form>
                </div>
            </div>

            <h2 class="text-xl font-bold">{{ $employee->name }}</h2>
            <p class="text-gray-600">{{ $employee->position }}</p>
            <p class="text-gray-600">{{ $employee->email }}</p>
            <p class="text-gray-600">{{ $employee->phone_number }}</p>
            <p class="text-gray-600">{{ $employee->employee_type }}</p>
        </div>
        @endforeach
    </div>
</div>

<script>
    function toggleDropdown(event, dropdownId) {
        event.stopPropagation();
        document.getElementById(dropdownId).classList.toggle('hidden');
    }

    // Klik di luar dropdown untuk menutup
    document.addEventListener("click", function() {
        document.querySelectorAll("[id^='dropdown-']").forEach(el => el.classList.add("hidden"));
    });

    // Fungsi untuk konfirmasi penghapusan
    function confirmDeletion(event, employeeId) {
        event.stopPropagation(); // Mencegah event klik dari card

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data karyawan akan dihapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + employeeId).submit();
            }
        });
    }
</script>
@endsection
