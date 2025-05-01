@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Buat Pengajuan Restock</h1>

        <form action="{{ route('restocks.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6" onsubmit="return validateForm()">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Karyawan</label>
                <input type="text" value="{{ Auth::user()->employee->name }}" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Tanggal dan Waktu Pengajuan</label>
                <input type="text" value="{{ now() }}" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Pilih Produk</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="item-container">
                    @foreach ($products as $product)
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="product_id" value="{{ $product->id }}" class="form-checkbox h-5 w-5 text-blue-600 item-checkbox">
                            <div class="ml-3">
                                <span class="block text-lg font-semibold">{{ $product->name }}</span>
                                <span class="block text-sm text-gray-600">Stok: {{ $product->stock }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <p id="item-error" class="text-red-500 text-sm mt-2 hidden">Silakan pilih 1 produk.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Jumlah Restock</label>
                <input type="number" name="restock_amount" id="restock_amount" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan jumlah restock" min="1">
                <p id="amount-error" class="text-red-500 text-sm mt-2 hidden">Silakan masukkan jumlah restock.</p>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Ajukan Restock</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    document.querySelectorAll('.item-checkbox').forEach(otherCheckbox => {
                        if (otherCheckbox !== this) {
                            otherCheckbox.checked = false;
                        }
                    });
                }
            });
        });

        function validateForm() {
            let itemSelected = false;
            let amountFilled = false;

            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                if (checkbox.checked) {
                    itemSelected = true;
                }
            });

            const amountInput = document.getElementById('restock_amount');
            if (amountInput.value.trim() !== '' && amountInput.value > 0) {
                amountFilled = true;
            }

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

            return itemSelected && amountFilled;
        }
    </script>
@endsection
