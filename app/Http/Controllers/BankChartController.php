<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use ConsoleTVs\Charts\Facades\Charts;

class BankChartController extends Controller
{
    public function index()
    {
        // Ambil data transaksi per bulan
        $transactions = Bank::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as month, SUM(jumlah) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format untuk chart
        $labels = $transactions->pluck('month');
        $data = $transactions->pluck('total');

        // Kirim data ke view
        return view('charts.bank', compact('labels', 'data'));
    }

    public function mutasi()
    {
        // Ambil data DB (debit)
        $debitTransactions = Bank::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as month, SUM(jumlah) as total")
            ->where('tipe_transaksi', 'DB')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Ambil data CR (credit)
        $creditTransactions = Bank::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as month, SUM(jumlah) as total")
            ->where('tipe_transaksi', 'CR')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

              // Debugging
    dd([
        'debitTransactions' => $debitTransactions,
        'creditTransactions' => $creditTransactions,
    ]);

        // Format untuk chart
        $labels = $debitTransactions->pluck('month')->merge($creditTransactions->pluck('month'))->unique()->sort();
        $debitData = $labels->map(fn($month) => $debitTransactions->firstWhere('month', $month)->total ?? 0);
        $creditData = $labels->map(fn($month) => $creditTransactions->firstWhere('month', $month)->total ?? 0);

        // Kirim data ke view
        return view('charts.mutasi', compact('labels', 'debitData', 'creditData'));
    }

    public function totalMutasi()
    {
        // Hitung total transaksi CR (Credit) dan DB (Debit)
        $totalCR = Bank::where('tipe_transaksi', 'CR')->sum('jumlah');
        $totalDB = Bank::where('tipe_transaksi', 'DB')->sum('jumlah');

        // Kirim data ke view
        return view('charts.total_mutasi', compact('totalCR', 'totalDB'));
    }

    public function totalMutasiPerBulan(Request $request)
    {
        // Ambil periode yang dipilih (format: YYYY-MM)
        $periode = $request->input('periode', date('Y-m')); // Default ke bulan ini jika tidak ada input

        // Ambil transaksi berdasarkan tipe (DB/CR) untuk periode tertentu
        $totalCR = Bank::where('tipe_transaksi', 'CR')
            ->whereMonth('tanggal', date('m', strtotime($periode)))
            ->whereYear('tanggal', date('Y', strtotime($periode)))
            ->sum('jumlah');
        
        $totalDB = Bank::where('tipe_transaksi', 'DB')
            ->whereMonth('tanggal', date('m', strtotime($periode)))
            ->whereYear('tanggal', date('Y', strtotime($periode)))
            ->sum('jumlah');

        // Kirim data ke view
        return view('charts.total_mutasi_per_bulan', compact('totalCR', 'totalDB', 'periode'));
    }

    public function totalMutasiPerTahun(Request $request)
    {
        // Ambil periode tahun yang dipilih
        $tahun = $request->input('tahun', date('Y')); // Default ke tahun ini jika tidak ada input

        // Hitung total transaksi CR (Credit) dan DB (Debit) untuk tahun tertentu
        $totalCR = Bank::where('tipe_transaksi', 'CR')
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $totalDB = Bank::where('tipe_transaksi', 'DB')
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        // Kirim data ke view
        return view('charts.total_mutasi_per_tahun', compact('totalCR', 'totalDB', 'tahun'));
    }

    public function mutasiHarian(Request $request)
    {
        // Ambil periode bulan yang dipilih (format: YYYY-MM)
        $periode = $request->input('periode', date('Y-m')); // Default ke bulan ini jika tidak ada input

        // Ambil transaksi harian (CR)
        $dailyCR = Bank::selectRaw("DATE(tanggal) as date, SUM(jumlah) as total")
            ->where('tipe_transaksi', 'CR')
            ->whereMonth('tanggal', date('m', strtotime($periode)))
            ->whereYear('tanggal', date('Y', strtotime($periode)))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Ambil transaksi harian (DB)
        $dailyDB = Bank::selectRaw("DATE(tanggal) as date, SUM(jumlah) as total")
            ->where('tipe_transaksi', 'DB')
            ->whereMonth('tanggal', date('m', strtotime($periode)))
            ->whereYear('tanggal', date('Y', strtotime($periode)))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk chart
        $labels = $dailyCR->pluck('date')->merge($dailyDB->pluck('date'))->unique()->sort();
        $crData = $labels->map(fn($date) => $dailyCR->firstWhere('date', $date)->total ?? 0);
        $dbData = $labels->map(fn($date) => $dailyDB->firstWhere('date', $date)->total ?? 0);

        return view('charts.mutasi_harian', compact('labels', 'crData', 'dbData', 'periode'));
    }
}
