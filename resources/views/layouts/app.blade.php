<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
</body>
</html>
