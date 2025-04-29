<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function month()
    {
        // Ambil daftar bulan dan tahun yang tersedia di database
        $availableMonths = Salary::selectRaw('DISTINCT month_year')
            ->orderBy('month_year', 'desc')
            ->get()
            ->map(function ($item) {
                $parts = explode('-', $item->month_year);
                return [
                    'year' => $parts[0],
                    'month' => $parts[1],
                    'month_year' => $item->month_year,
                    'month_name' => \Carbon\Carbon::createFromDate($parts[0], $parts[1], 1)->locale('id')->isoFormat('MMMM YYYY')
                ];
            });

        // Buat daftar 12 bulan terakhir termasuk bulan saat ini
        $months = [];
        $currentDate = now();

        for ($i = 0; $i < 12; $i++) {
            $date = $currentDate->copy()->subMonths($i);
            $monthYear = $date->format('Y-m');
            $monthName = $date->locale('id')->isoFormat('MMMM YYYY');

            $months[] = [
                'year' => $date->year,
                'month' => $date->month,
                'month_year' => $monthYear,
                'month_name' => $monthName,
                'has_data' => $availableMonths->contains('month_year', $monthYear)
            ];
        }

        return view('penggajian.month', compact('months'));
    }

    public function index(Request $request, $monthYear)
    {
        $salaries = Salary::with('employee')
            ->where('month_year', $monthYear)
            ->orderBy('date', 'desc')
            ->get();

        // Parse bulan dan tahun untuk ditampilkan
        $parts = explode('-', $monthYear);
        $monthName = \Carbon\Carbon::createFromDate($parts[0], $parts[1], 1)->locale('id')->isoFormat('MMMM YYYY');

        return view('penggajian.index', compact('salaries', 'monthYear', 'monthName'));
    }

    public function create($monthYear)
    {
        $employees = Employee::whereDoesntHave('salaries', function($query) use ($monthYear) {
            $query->where('month_year', $monthYear);
        })->get();

        $parts = explode('-', $monthYear);
        $monthName = \Carbon\Carbon::createFromDate($parts[0], $parts[1], 1)->locale('id')->isoFormat('MMMM YYYY');

        return view('penggajian.create', compact('employees', 'monthYear', 'monthName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month_year' => 'required',
            'employee_id' => 'required|exists:employees,id',
            'attendance_count' => 'required|integer|min:0|max:26',
            'incentive' => 'required|numeric|min:0', // Gunakan nilai dari input hidden
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $baseSalary = $employee->net_salary ?? 0;
        $totalSalary = $baseSalary + $request->incentive;

        $salary = Salary::create([
            'date' => now(),
            'month_year' => $request->month_year,
            'employee_id' => $request->employee_id,
            'attendance_count' => $request->attendance_count,
            'incentive' => $request->incentive, // Nilai sudah tanpa format
            'total_salary' => $totalSalary,
        ]);

        return redirect()->route('penggajian.index', $request->month_year)
            ->with('success', 'Data penggajian berhasil ditambahkan.');
    }

    public function edit(Salary $salary)
    {
        return view('penggajian.edit', compact('salary'));
    }

    public function update(Request $request, Salary $salary)
    {
        $request->validate([
            'attendance_count' => 'required|integer|min:0|max:26',
            'incentive' => 'required|numeric|min:0', // Gunakan nilai dari input hidden
        ]);

        $baseSalary = $salary->employee->net_salary ?? 0;
        $totalSalary = $baseSalary + $request->incentive;

        $salary->update([
            'attendance_count' => $request->attendance_count,
            'incentive' => $request->incentive, // Nilai sudah tanpa format
            'total_salary' => $totalSalary,
        ]);

        return redirect()->route('penggajian.index', $salary->month_year)
            ->with('success', 'Data penggajian berhasil diperbarui.');
    }

    public function destroy(Salary $salary)
    {
        $monthYear = $salary->month_year;
        $salary->delete();

        return redirect()->route('penggajian.index', $monthYear)
            ->with('success', 'Data penggajian berhasil dihapus.');
    }
}
