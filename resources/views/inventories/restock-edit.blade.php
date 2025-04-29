@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Edit Pengajuan Restock</h1>

        <!-- Form Edit Restock -->
        <form action="{{ route('restocks.update', $restock->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <!-- Nama Karyawan (Otomatis) -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Karyawan</label>
                <input type="text" value="{{ $restock->employee->name }}" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
            </div>

            <!-- Tanggal dan Waktu Pengajuan (Otomatis) -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Tanggal dan Waktu Pengajuan</label>
                <input type="text" value="{{ $restock->date }}" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
            </div>

            <!-- Pilih Item (Checkbox Card) -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Pilih Item</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="item-container">
                    @foreach ($inventories as $inventory)
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="id_items" value="{{ $inventory->id }}" class="form-checkbox h-5 w-5 text-blue-600 item-checkbox"
                                {{ $restock->id_items == $inventory->id ? 'checked' : '' }}>
                            <div class="ml-3">
                                <span class="block text-lg font-semibold">{{ $inventory->name_items }}</span>
                                <span class="block text-sm text-gray-600">{{ $inventory->type_items }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <p id="item-error" class="text-red-500 text-sm mt-2 hidden">Silakan pilih 1 item.</p>
            </div>

            <!-- Jumlah Restock -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Jumlah Restock</label>
                <input type="number" name="restock_amount" id="restock_amount" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan jumlah restock" value="{{ $restock->restock_amount }}" min="1">
                <p id="amount-error" class="text-red-500 text-sm mt-2 hidden">Silakan masukkan jumlah restock.</p>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
                <a href="{{ route('restocks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 ml-2">Batal</a>
            </div>
        </form>
    </div>

    <!-- JavaScript untuk Validasi -->
    <script>
        // Fungsi untuk memastikan hanya 1 checkbox yang dipilih
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // Uncheck semua checkbox lainnya
                    document.querySelectorAll('.item-checkbox').forEach(otherCheckbox => {
                        if (otherCheckbox !== this) {
                            otherCheckbox.checked = false;
                        }
                    });
                }
            });
        });

        // Fungsi untuk validasi form sebelum submit
        function validateForm() {
            let itemSelected = false;
            let amountFilled = false;

            // Cek apakah ada item yang dipilih
            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                if (checkbox.checked) {
                    itemSelected = true;
                }
            });

            // Cek apakah jumlah restock sudah diisi
            const amountInput = document.getElementById('restock_amount');
            if (amountInput.value.trim() !== '' && amountInput.value > 0) {
                amountFilled = true;
            }

            // Tampilkan pesan error jika validasi gagal
            if (!itemSelected) {
                document.getElementById('item-error').classList.remove('hidden');
            } else {
                document.getElementById('item-error').classList.add('hidden');
            }

            if (!amountFilled) {
                document.getElementById('amount-error').classList.remove('hidden');
            } else {
                document.getElementById('amount-error').classList.add('hidden');
            }

            // Kembalikan false jika validasi gagal
            return itemSelected && amountFilled;
        }
    </script>
@endsection
