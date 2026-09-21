<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Carbon\Carbon;

class RekapController extends Controller
{
    public function index()
    {
        return view('laporan');
    }

    public function rekapMingguan(Request $request)
    {
        // Cek apakah user memilih tanggal tertentu dari kalender
        if ($request->filled('tanggal')) {
            // Ambil data berdasarkan 1 hari penuh (dari jam 00:00:00 sampai 23:59:59)
            $selectedDate = Carbon::parse($request->tanggal);
            $startDate    = $selectedDate->copy()->startOfDay();
            $endDate      = $selectedDate->copy()->endOfDay();
        } else {
            // Default jika belum memilih tanggal (misal: Hari ini)
            $startDate = Carbon::today()->startOfDay();
            $endDate   = Carbon::today()->endOfDay();
        }

        $penjualan = Penjualan::with(['itemPenjualan.produk', 'user'])
            ->where('status', 'COMPLETED')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalOmset     = $penjualan->sum('total_pembayaran');
        $totalTransaksi = $penjualan->count();
        $totalCash      = $penjualan->where('metode_pembayaran', 'CASH')->sum('total_pembayaran');
        $totalQris      = $penjualan->where('metode_pembayaran', 'QRIS')->sum('total_pembayaran');

        return view('laporan', compact(
            'penjualan',
            'totalOmset',
            'totalTransaksi',
            'totalCash',
            'totalQris',
            'startDate',
            'endDate'
        ));
    }
}