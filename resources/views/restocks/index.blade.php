@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Daftar Pengajuan Restock</h1>

        <div class="flex justify-end mb-4">
            <a href="{{ route('restocks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Buat Pengajuan Restock</a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3">Nama Karyawan</th>
                        <th class="px-4 py-3">Tanggal dan Waktu Pengajuan</th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3">Jumlah Restock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($restocks as $restock)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="px-4 py-3 text-center">{{ $restock->employee->name }}</td>
                            <td class="px-4 py-3 text-center">{{ $restock->date }}</td>
                            <td class="px-4 py-3 text-center">{{ $restock->product->name }}</td>
                            <td class="px-4 py-3 text-center">{{ $restock->restock_amount }}</td>
                            <td class="px-4 py-3 text-center">
                                <select
                                    class="status-dropdown border rounded p-1"
                                    data-id="{{ $restock->id }}"
                                    data-current-stock="{{ $restock->product->stock }}"
                                    data-restock-amount="{{ $restock->restock_amount }}"
                                    {{ $restock->status != 'Dalam Proses' ? 'disabled' : '' }}
                                >
                                    <option value="Dalam Proses" {{ $restock->status == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                    <option value="Diterima" {{ $restock->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Ditolak" {{ $restock->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($restock->status == 'Dalam Proses')
                                    <a href="{{ route('restocks.edit', $restock->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">Edit</a>
                                @endif
                                @if($restock->status != 'Diterima')
                                    <button onclick="confirmDelete({{ $restock->id }})" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 ml-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
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
                title: 'Apakah yakin ingin menghapus data restock ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                Swal.fire({
                    title: 'Masukkan Password',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: (password) => {
                        if (!password) {
                            throw new Error('Password tidak boleh kosong');
                        }
                        return fetch(`/restocks/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ password: password })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(data => {
                                    throw new Error(data.message || 'Terjadi kesalahan!');
                                });
                            }
                            return response.json();
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isDismissed) {
                        return;
                    }

                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    if (result.value && result.value.success) {
                        setTimeout(() => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: result.value.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload();
                            });
                        }, 1000);
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: result.value?.message || 'Terjadi kesalahan!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }).catch((error) => {
                    Swal.fire({
                        title: 'Gagal!',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            });
        }

        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const originalValue = this.value;
                const originalStatus = "Dalam Proses";
                const restockId = this.dataset.id;
                const currentStock = this.dataset.currentStock;
                const restockAmount = this.dataset.restockAmount;

                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Ubah status menjadi "${this.value}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal'
                }).then((firstResult) => {
                    if (!firstResult.isConfirmed) {
                        this.value = originalStatus;
                        return;
                    }

                    Swal.fire({
                        title: 'Verifikasi Password',
                        input: 'password',
                        inputAttributes: { autocapitalize: 'off' },
                        showCancelButton: true,
                        confirmButtonText: 'Verifikasi',
                        cancelButtonText: 'Batal',
                        showLoaderOnConfirm: true,
                        preConfirm: (password) => {
                            return fetch(`/restocks/${restockId}/update-status`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    status: originalValue,
                                    current_stock: currentStock,
                                    restock_amount: restockAmount,
                                    password: password
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(err => {
                                        throw new Error(err.message || 'Verifikasi gagal');
                                    });
                                }
                                return response.json();
                            });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((passwordResult) => {
                        Swal.close();

                        if (passwordResult.isDismissed) {
                            this.value = originalStatus;
                            return;
                        }

                        if (passwordResult.value?.success) {
                            const product = passwordResult.value.product_data;

                            Swal.fire({
                                title: 'Stok Terupdate!',
                                html: `
                                    <div class="text-left">
                                        <p class="mb-2">${product.item_name}</p>
                                        <p>Stok Lama: <strong>${product.old_stock}</strong></p>
                                        <p>Stok Baru: <strong class="text-green-600">${product.new_stock}</strong></p>
                                        <p class="mt-2 text-sm">Total penambahan: +${product.new_stock - product.old_stock}</p>
                                    </div>
                                `,
                                icon: 'success',
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                showCancelButton: true,
                                cancelButtonText: 'Lihat Produk',
                                allowOutsideClick: false,
                                customClass: {
                                    loader: 'hidden'
                                }
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.cancel) {
                                    window.location.href = "{{ route('products.index') }}";
                                } else {
                                    window.location.reload();
                                }
                            });
                        } else {
                            this.value = originalStatus;
                            Swal.fire({
                                title: 'Gagal!',
                                text: passwordResult.value?.message || 'Terjadi kesalahan',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }).catch((error) => {
                        Swal.close();
                        this.value = originalStatus;
                        Swal.fire({
                            title: 'Error!',
                            text: error.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                });
            });
        });
    </script>
@endsection
