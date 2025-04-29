<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    public function month(Request $request)
    {
        // Ambil tahun yang dipilih dari request atau default tahun sekarang
        $selectedYear = $request->input('year', date('Y'));

        // Ambil daftar tahun yang tersedia di database
        $availableYears = Jurnal::selectRaw('YEAR(transaction_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Jika tahun yang dipilih tidak ada di database, tambahkan ke available years
        if (!$availableYears->contains($selectedYear)) {
            $availableYears->push($selectedYear)->sortDesc();
        }

        // Buat daftar 12 bulan untuk tahun yang dipilih
        $months = [];
        for ($month = 1; $month <= 12; $month++) {
            $date = \Carbon\Carbon::create($selectedYear, $month, 1);
            $monthYear = $date->format('Y-m');

            // Cek apakah bulan ini memiliki data
            $hasData = Jurnal::where('month_year', $monthYear)->exists();

            $months[] = [
                'year' => $selectedYear,
                'month' => $month,
                'month_year' => $monthYear,
                'month_name' => $date->locale('id')->isoFormat('MMMM YYYY'),
                'has_data' => $hasData
            ];
        }

        return view('jurnal.month', [
            'months' => $months,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears
        ]);
    }

    public function index(Request $request, $monthYear)
    {
        $jurnals = Jurnal::where('month_year', $monthYear)
            ->orderBy('transaction_date', 'asc')
            ->get();

        // Hitung total
        $totalDebit = $jurnals->where('transaction_type', 'Debit')->sum('amount');
        $totalKredit = $jurnals->where('transaction_type', 'Kredit')->sum('amount');

        // Parse bulan dan tahun untuk ditampilkan
        $parts = explode('-', $monthYear);
        $monthName = \Carbon\Carbon::createFromDate($parts[0], $parts[1], 1)->locale('id')->isoFormat('MMMM YYYY');

        return view('jurnal.index', compact('jurnals', 'monthYear', 'monthName', 'totalDebit', 'totalKredit'));
    }

    public function create($monthYear)
    {
        return view('jurnal.create', compact('monthYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'month_year' => 'required',
            'transaction_type' => 'required|in:Debit,Kredit',
            'description' => 'required',
            'amount' => 'required|numeric',
            'debit_account' => 'required',
            'credit_account' => 'required',
        ]);

        // Format amount ke decimal
        $validated['amount'] = (float) str_replace('.', '', $validated['amount']);

        Jurnal::create($validated);

        return redirect()->route('jurnal.index', $validated['month_year'])
            ->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function edit(Jurnal $jurnal)
    {
        return view('jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, Jurnal $jurnal)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:Debit,Kredit',
            'description' => 'required',
            'amount' => 'required|numeric',
            'debit_account' => 'required',
            'credit_account' => 'required',
        ]);

        // Format amount ke decimal
        $validated['amount'] = (float) str_replace('.', '', $validated['amount']);

        $jurnal->update($validated);

        return redirect()->route('jurnal.index', $jurnal->month_year)
            ->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Jurnal $jurnal)
    {
        $monthYear = $jurnal->month_year;
        $jurnal->delete();

        return redirect()->route('jurnal.index', $monthYear)
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}
