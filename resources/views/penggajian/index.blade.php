@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Penggajian Bulan {{ $monthName }}</h1>
        <a href="{{ route('penggajian.create', $monthYear) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-200">
            Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Gaji</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Karyawan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insentif</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Gaji</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($salaries as $salary)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $salary->salary_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $salary->date->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $salary->employee->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $salary->attendance_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($salary->incentive, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($salary->total_salary, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('penggajian.edit', $salary->id) }}" class="text-blue-500 hover:text-blue-700 mr-3">Edit</a>
                            <button onclick="confirmDelete({{ $salary->id }})" class="text-red-500 hover:text-red-700">
                                Hapus
                            </button>

                            <!-- Form Delete (hidden) -->
                            <form id="delete-form-{{ $salary->id }}" action="{{ route('penggajian.destroy', $salary->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data penggajian untuk bulan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data penggajian akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
