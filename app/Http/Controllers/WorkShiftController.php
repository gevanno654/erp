<?php

namespace App\Http\Controllers;

use App\Models\WorkShift;
use App\Models\Employee;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    // Menampilkan halaman index
    public function index()
    {
        $workShifts = WorkShift::with('employees')->get();
        return view('work-shifts.index', compact('workShifts'));
    }

    // Menampilkan halaman create
    public function create()
    {
        $employees = Employee::all();
        return view('work-shifts.create', compact('employees'));
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name_day' => 'required|string',
            'name_shift' => 'required|string',
            'work_start' => 'required|date_format:H:i',
            'work_finish' => 'required|date_format:H:i',
            'employee_id' => 'required|array', // Karyawan dipilih sebagai array
        ]);

        // Simpan work shift
        $workShift = WorkShift::create([
            'name_day' => $request->name_day,
            'name_shift' => $request->name_shift,
            'work_start' => $request->work_start,
            'work_finish' => $request->work_finish,
        ]);

        // Hubungkan work shift dengan karyawan yang dipilih
        $workShift->employees()->attach($request->employee_id);

        return redirect()->route('work-shifts.index')->with('success', 'Work shift created successfully.');
    }

    public function show($id)
    {
        $workShift = WorkShift::with('employees')->findOrFail($id); // Ambil data work shift beserta karyawan
        $employees = Employee::all(); // Ambil semua karyawan
        return view('work-shifts.show', compact('workShift', 'employees'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name_day' => 'required|string',
            'name_shift' => 'required|string',
            'work_start' => 'required|date_format:H:i',
            'work_finish' => 'required|date_format:H:i',
            'employee_id' => 'required|array', // Karyawan dipilih sebagai array
        ]);

        // Ambil work shift yang akan diupdate
        $workShift = WorkShift::findOrFail($id);

        // Update data work shift
        $workShift->update([
            'name_day' => $request->name_day,
            'name_shift' => $request->name_shift,
            'work_start' => $request->work_start,
            'work_finish' => $request->work_finish,
        ]);

        // Sync karyawan yang dipilih
        $workShift->employees()->sync($request->employee_id);

        return redirect()->route('work-shifts.index')->with('success', 'Work shift updated successfully.');
    }

    public function destroy($id)
    {
        // Ambil data work shift
        $workShift = WorkShift::findOrFail($id);

        // Soft delete work shift
        $workShift->delete();

        // Soft delete relasi di tabel pivot
        $workShift->employees()->updateExistingPivot($workShift->employees->pluck('id'), ['deleted_at' => now()]);

        return redirect()->route('work-shifts.index')->with('success', 'Work shift deleted successfully.');
    }
}
