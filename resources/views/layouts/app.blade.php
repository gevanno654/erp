<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ERP Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        select.status-dropdown:disabled {
            background-color: #f3f4f6;
            color: #6b7280;
            cursor: not-allowed;
            opacity: 1; /* Override default opacity */
        }

        select.status-dropdown:disabled option {
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 min-h-screen p-4">
            <h1 class="text-2xl font-bold mb-6">ERP System</h1>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('dashboard') }}" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('employees.index') }}" class="block py-2 px-4 hover:bg-gray-700">Employees</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('attendances.index') }}" class="block py-2 px-4 hover:bg-gray-700">Attendances</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('work-shifts.index') }}" class="block py-2 px-4 hover:bg-gray-700">Work Shifts</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('assets.index') }}" class="block py-2 px-4 hover:bg-gray-700">Assets</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('products.index') }}" class="block py-2 px-4 hover:bg-gray-700">Products</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('restocks.index') }}" class="block py-2 px-4 hover:bg-gray-700">Restock</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('mitra.index') }}" class="block py-2 px-4 hover:bg-gray-700">Mitra</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('orders.index') }}" class="block py-2 px-4 hover:bg-gray-700">Pesanan</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('logistics.index') }}" class="block py-2 px-4 hover:bg-gray-700">Logistik</a>
                </li>
                {{-- <li class="mb-2">
                    <a href="{{ route('restocks.index') }}" class="block py-2 px-4 hover:bg-gray-700">Restock</a>
                </li> --}}
                <li class="mb-2">
                    <a href="{{ route('jurnal.month') }}" class="block py-2 px-4 hover:bg-gray-700">Jurnal</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('penggajian.month') }}" class="block py-2 px-4 hover:bg-gray-700">Penggajian</a>
                </li>
                {{-- <li class="mb-2">
                    <a href="{{ route('inventories.product') }}" class="block py-2 px-4 hover:bg-gray-700">Product</a>
                </li> --}}
                <!-- Tambahkan menu lain di sini -->
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            @yield('content')
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-mask@1.0.0/dist/alpine-mask.min.js"></script>
</body>
</html>
