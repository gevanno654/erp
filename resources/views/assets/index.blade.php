@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Aset</h1>
            <a href="{{ route('assets.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Tambah Aset</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Tabel Aset -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Aset</th>
                        <th class="px-4 py-3">Tipe Aset</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($assets as $index => $asset)
                        <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $asset->name_items }}</td>
                            <td class="px-4 py-3">{{ $asset->type_items }}</td>
                            <td class="px-4 py-3 text-center">{{ $asset->items_stock }}</td>
                            <td class="px-4 py-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('assets.edit', $asset->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">Edit</a>
                                    <button onclick="confirmDelete('{{ $asset->id }}')" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Hapus</button>
                                    <form id="delete-form-{{ $asset->id }}" action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
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
            })
        }

        // Tampilkan SweetAlert jika ada session success
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@endsection
