@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Mitra</h1>

    <form action="{{ route('mitra.update', $mitra->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="nama_mitra" class="block text-sm font-medium text-gray-700">Nama Mitra</label>
                <input type="text" name="nama_mitra" id="nama_mitra" required value="{{ $mitra->nama_mitra }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Mitra</label>
                <textarea name="alamat" id="alamat" rows="3" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $mitra->alamat }}</textarea>
            </div>

            <div>
                <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" required value="{{ $mitra->nomor_telepon }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tahun_awal_kerjasama" class="block text-sm font-medium text-gray-700">Tahun Awal Kerjasama</label>
                    <input type="text" name="tahun_awal_kerjasama" id="tahun_awal_kerjasama" required value="{{ $mitra->tahun_awal_kerjasama }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="tahun_akhir_kerjasama" class="block text-sm font-medium text-gray-700">Tahun Akhir Kerjasama</label>
                    <div class="flex">
                        <input type="text" name="tahun_akhir_kerjasama" id="tahun_akhir_kerjasama" required value="{{ $mitra->tahun_akhir_kerjasama }}"
                            class="mt-1 block w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="button" onclick="document.getElementById('tahun_akhir_kerjasama').value = 'Sekarang'"
                            class="mt-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md transition duration-200">
                            Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('mitra.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200 mr-3">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
