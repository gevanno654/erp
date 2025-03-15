<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $users = User::whereNotIn('id', Employee::pluck('user_id'))->get();
        $managers = Employee::where('position', 'LIKE', 'Kepala%')->get();

        return view('employees.create', compact('users', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:employees,user_id',
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'manager' => 'nullable|string|max:255',
            'employee_type' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|string|max:15',
            'ktp_address' => 'required|string',
            'ktp_city' => 'required|string|max:255',
            'domicile_address' => 'required|string',
            'domicile_city' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'net_salary' => 'required|numeric',
            'nationality' => 'required|string|max:255',
            'ktp_number' => 'required|string|max:255|unique:employees,ktp_number',
            'gender' => 'required|string|max:10',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'educational_level' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'marital_status' => 'required|string|in:Belum Menikah,Sudah Menikah,Cerai Hidup,Cerai Mati',
            'spouse_complete_name' => 'nullable|string|max:255',
            'number_of_dependent_children' => 'required|integer|min:0',
        ]);

        // Jika belum menikah, kosongkan nama pasangan dan set jumlah anak ke 0
        if ($request->marital_status !== 'Sudah Menikah') {
            $request->merge([
                'spouse_complete_name' => null,
                'number_of_dependent_children' => 0,
            ]);
        }

        // Simpan data karyawan
        Employee::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'department' => $request->department,
            'position' => $request->position,
            'manager' => $request->manager,
            'employee_type' => $request->employee_type,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'ktp_address' => $request->ktp_address,
            'ktp_city' => $request->ktp_city,
            'domicile_address' => $request->domicile_address,
            'domicile_city' => $request->domicile_city,
            'bank_account' => $request->bank_account,
            'net_salary' => $request->net_salary,
            'nationality' => $request->nationality,
            'ktp_number' => $request->ktp_number,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'place_of_birth' => $request->place_of_birth,
            'educational_level' => $request->educational_level,
            'field_of_study' => $request->field_of_study,
            'school' => $request->school,
            'marital_status' => $request->marital_status,
            'spouse_complete_name' => $request->spouse_complete_name,
            'number_of_dependent_children' => $request->number_of_dependent_children,
        ]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Employee $employee)
    {
        $managers = Employee::where('position', 'LIKE', 'Kepala%')->get();

        return view('employees.show', compact('employee', 'managers'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'manager' => 'nullable|string|max:255',
            'employee_type' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone_number' => 'required|string|max:15',
            'ktp_address' => 'required|string',
            'ktp_city' => 'required|string|max:255',
            'domicile_address' => 'required|string',
            'domicile_city' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'net_salary' => 'required|numeric',
            'nationality' => 'required|string|max:255',
            'ktp_number' => 'required|string|max:255|unique:employees,ktp_number,' . $employee->id,
            'gender' => 'required|string|max:10',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'educational_level' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'marital_status' => 'required|string|in:Belum Menikah,Sudah Menikah,Cerai Hidup,Cerai Mati',
            'spouse_complete_name' => 'nullable|string|max:255',
            'number_of_dependent_children' => 'integer|min:0',
        ]);

        // Jika belum menikah, kosongkan nama pasangan dan set jumlah anak ke 0
        if ($request->marital_status === 'Belum Menikah') {
            $request->merge([
                'spouse_complete_name' => null,
                'number_of_dependent_children' => 0,
            ]);
        } elseif ($request->has('no_children') && $request->no_children) {
            $request->merge([
                'number_of_dependent_children' => 0,
            ]);
        }

        // Perbarui data karyawan
        $employee->update([
            'name' => $request->name,
            'department' => $request->department,
            'position' => $request->position,
            'manager' => $request->manager,
            'employee_type' => $request->employee_type,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'ktp_address' => $request->ktp_address,
            'ktp_city' => $request->ktp_city,
            'domicile_address' => $request->domicile_address,
            'domicile_city' => $request->domicile_city,
            'bank_account' => $request->bank_account,
            'net_salary' => $request->net_salary,
            'nationality' => $request->nationality,
            'ktp_number' => $request->ktp_number,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'place_of_birth' => $request->place_of_birth,
            'educational_level' => $request->educational_level,
            'field_of_study' => $request->field_of_study,
            'school' => $request->school,
            'marital_status' => $request->marital_status,
            'spouse_complete_name' => $request->spouse_complete_name,
            'number_of_dependent_children' => $request->number_of_dependent_children,
        ]);

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
