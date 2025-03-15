<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        // Ambil ID karyawan yang sedang login
        $employeeId = Auth::user()->employee->id;

        // Cek apakah sudah check-in hari ini
        $hasCheckedIn = Attendance::where('employee_id', $employeeId)
            ->where('date', now()->toDateString())
            ->whereNotNull('check_in')
            ->exists();

        // Cek apakah sudah check-out hari ini
        $hasCheckedOut = Attendance::where('employee_id', $employeeId)
            ->where('date', now()->toDateString())
            ->whereNotNull('check_out')
            ->exists();

        // Ambil data absensi karyawan
        $attendances = Attendance::where('employee_id', $employeeId)->get();

        return view('attendances.index', compact('attendances', 'hasCheckedIn', 'hasCheckedOut'));
    }

    public function checkIn()
    {
        // Ambil ID karyawan yang sedang login
        $employeeId = Auth::user()->employee->id;

        // Cek apakah sudah ada data absensi hari ini
        $attendance = Attendance::where('employee_id', $employeeId)
            ->where('date', now()->toDateString())
            ->first();

        // Jika belum ada, buat data absensi baru
        if (!$attendance) {
            Attendance::create([
                'employee_id' => $employeeId,
                'date' => now()->toDateString(),
                'check_in' => now()->toTimeString(),
                'status' => 'Tidak Hadir', // Default status
            ]);
        }

        return redirect()->route('attendances.index')->with('success', 'Presensi hadir berhasil!');
    }

    public function checkOut()
    {
        // Ambil ID karyawan yang sedang login
        $employeeId = Auth::user()->employee->id;

        // Cari data absensi hari ini
        $attendance = Attendance::where('employee_id', $employeeId)
            ->where('date', now()->toDateString())
            ->first();

        // Jika ada, update data absensi
        if ($attendance) {
            $attendance->update([
                'check_out' => now()->toTimeString(),
                'status' => 'Hadir',
                'worked_time' => $this->calculateWorkedTime($attendance->check_in, now()->toTimeString()),
            ]);
        }

        return redirect()->route('attendances.index')->with('success', 'Presensi pulang berhasil!');
    }

    private function calculateWorkedTime($checkIn, $checkOut)
    {
        $checkInTime = strtotime($checkIn);
        $checkOutTime = strtotime($checkOut);
        $workedTime = abs($checkOutTime - $checkInTime); // Durasi dalam detik
        return gmdate('H:i:s', $workedTime); // Format ke jam:menit:detik
    }

    public function create()
    {
        // Ambil semua data karyawan untuk dropdown
        $employees = Employee::all();
        return view('attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'required|date_format:H:i|after:check_in',
            'status' => 'required|in:Hadir,Absen,Sakit,Izin',
        ]);

        // Hitung durasi kerja dalam format HH:MM:SS
        $checkInTime = strtotime($request->check_in);
        $checkOutTime = strtotime($request->check_out);
        $workedTime = abs($checkOutTime - $checkInTime); // Durasi dalam detik
        $workedTimeFormatted = gmdate('H:i:s', $workedTime); // Format ke HH:MM:SS

        // Simpan data absensi
        Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date, // Format YYYY-MM-DD
            'check_in' => $request->check_in, // Format 24 jam (HH:MM)
            'check_out' => $request->check_out, // Format 24 jam (HH:MM)
            'worked_time' => $workedTimeFormatted, // Format HH:MM:SS
            'status' => $request->status,
        ]);

        return redirect()->route('attendances.index')->with('success', 'Absensi manual berhasil disimpan!');
    }

    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        return view('attendances.show', compact('attendance', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        // Validasi input
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'required|date_format:H:i|after:check_in',
            'status' => 'required|in:Hadir,Absen,Sakit,Izin',
        ]);

        // Hitung durasi kerja
        $checkInTime = strtotime($request->check_in);
        $checkOutTime = strtotime($request->check_out);
        $workedTime = abs($checkOutTime - $checkInTime); // Durasi dalam detik
        $workedTimeFormatted = gmdate('H:i:s', $workedTime); // Format ke HH:MM:SS

        // Update data absensi
        $attendance->update([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'worked_time' => $workedTimeFormatted,
            'status' => $request->status,
        ]);

        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete(); // Ini akan melakukan soft delete (mengisi deleted_at)

        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil dihapus!');
    }
}
