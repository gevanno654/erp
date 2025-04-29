@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Daftar Pengajuan Restock</h1>

        <div class="flex justify-end mb-4">
            <a href="{{ route('restocks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Buat Pengajuan Restock</a>
        </div>

        <!-- Tabel Restock -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3">Nama Karyawan</th>
                        <th class="px-4 py-3">Tanggal dan Waktu Pengajuan</th>
                        <th class="px-4 py-3">Nama Item</th>
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
                            <td class="px-4 py-3 text-center">{{ $restock->inventory->name_items }}</td>
                            <td class="px-4 py-3 text-center">{{ $restock->restock_amount }}</td>
                            <td class="px-4 py-3 text-center">
                                <select
                                    class="status-dropdown border rounded p-1"
                                    data-id="{{ $restock->id }}"
                                    data-current-stock="{{ $restock->inventory->items_stock }}"
                                    data-restock-amount="{{ $restock->restock_amount }}"
                                    {{ $restock->status != 'Dalam Proses' ? 'disabled' : '' }}
                                >
                                    <option value="Dalam Proses" {{ $restock->status == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                    <option value="Diterima" {{ $restock->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Ditolak" {{ $restock->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <!-- Tombol Edit -->
                                <a href="{{ route('restocks.edit', $restock->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">Edit</a>

                                <!-- Tombol Delete -->
                                <button onclick="confirmDelete({{ $restock->id }})" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 ml-2">
                                    <i class="fas fa-trash"></i> <!-- Icon sampah dari FontAwesome -->
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Fungsi untuk konfirmasi delete (yang sudah diperbaiki)
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
                    return; // Langsung return jika tidak dikonfirmasi
                }

                // Tampilkan popup password
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
                    // Handle hasil dari popup password
                    if (result.isDismissed) {
                        return; // Jika dibatalkan, langsung return
                    }

                    // Tampilkan loading hanya jika dikonfirmasi
                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Proses hasil
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

        // Fungsi untuk konfirmasi update status pengajuan restock
        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const originalValue = this.value;
                const originalStatus = "Dalam Proses";
                const restockId = this.dataset.id;
                const currentStock = this.dataset.currentStock;
                const restockAmount = this.dataset.restockAmount;

                // Konfirmasi pertama
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

                    // Popup verifikasi password
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
                        // Tutup semua popup sebelumnya termasuk loader
                        Swal.close();

                        if (passwordResult.isDismissed) {
                            this.value = originalStatus;
                            return;
                        }

                        if (passwordResult.value?.success) {
                            const inventory = passwordResult.value.inventory_data;

                            // Tampilkan popup hasil tanpa loader
                            Swal.fire({
                                title: 'Stok Terupdate!',
                                html: `
                                    <div class="text-left">
                                        <p class="mb-2">${inventory.item_name}</p>
                                        <p>Stok Lama: <strong>${inventory.old_stock}</strong></p>
                                        <p>Stok Baru: <strong class="text-green-600">${inventory.new_stock}</strong></p>
                                        <p class="mt-2 text-sm">Total penambahan: +${inventory.new_stock - inventory.old_stock}</p>
                                    </div>
                                `,
                                icon: 'success',
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                showCancelButton: true,
                                cancelButtonText: 'Lihat Inventory',
                                allowOutsideClick: false,
                                customClass: {
                                    loader: 'hidden' // Pastikan loader tidak muncul
                                }
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.cancel) {
                                    window.location.href = "{{ route('inventories.index') }}";
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
                        Swal.close(); // Pastikan semua popup tertutup
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
