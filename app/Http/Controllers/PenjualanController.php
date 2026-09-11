<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(SearchRequest $request)
{
    $user = Auth::user();
    $keyword = $request->input('search');

    $sales = Penjualan::query()

        //  Filter berdasarkan role
        ->when($user->role->name == 'kasir', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })

        // 🔍 Search nama user
        ->when($keyword, function ($query) use ($keyword) {
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
            });
        })

        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('penjualan.index', compact('sales'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(SearchRequest $request)
    {
        $sale = Penjualan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status' => 'OPEN'
            ],
            [
                'total_pembayaran' => 0,
                'metode_pembayaran' => 'CASH'
            ]
        );
        $keyword = $request->input('search');

        if($keyword) {
            $products = Produk::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->orderBy('nama')
            ->get();
        } else {
            $products = Produk::orderBy('nama')->get();
        }
        
        $mode = 'create';

return view('penjualan.pos', compact('sale', 'products', 'mode'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        $this->authorize('view', $penjualan);

        $penjualan->load(['user', 'itemPenjualan.produk.jenis']);

        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
        public function edit(Penjualan $penjualan)
    {
        $this->authorize('update', $penjualan);

        $sale = $penjualan;

        abort_if($sale->status === 'COMPLETED', 493);

        $sale->load('itemPenjualan');
        $products = Produk::orderBy('nama')->get();
        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    public function update(Request $request, Penjualan $penjualan)
{
    $this->authorize('update', $penjualan);

    $request->validate([
        'payment_method' => 'required|in:CASH,QRIS',
        'uang_dibayar'   => 'required_if:payment_method,CASH|nullable|integer|min:0',
    ]);

    if ($penjualan->status !== 'OPEN') {
        return back()->with('errors', 'Transaksi sudah diproses');
    }

    if ($penjualan->itemPenjualan()->count() === 0) {
        return back()->with('errors', 'Keranjang masih kosong');
    }

    $total = $penjualan->itemPenjualan()->sum('subtotal');

    $uangDibayar = $request->payment_method === 'CASH'
        ? (int) $request->uang_dibayar
        : null;

    if ($request->payment_method === 'CASH' && $uangDibayar < $total) {
        return back()->withInput()->with('errors', 'Uang yang diberikan kurang dari total pembayaran');
    }

    DB::transaction(function () use ($penjualan, $total, $uangDibayar, $request) {
        $penjualan->update([
            'metode_pembayaran' => $request->payment_method,
            'total_pembayaran'  => $total,
            'uang_dibayar'      => $uangDibayar,
            'status'            => 'COMPLETED'
        ]);
    });

    return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diselesaikan');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
{
    $this->authorize('delete', $penjualan);
    // ❗ Pastikan hanya transaksi OPEN
    if ($penjualan->status !== 'OPEN') {
        return redirect()->route('penjualan.create')->with('errors', 'Transaksi sudah selesai tidak bisa dibatalkan');
    }

DB::transaction(function () use ($penjualan) {

        foreach ($penjualan->itemPenjualan as $item) {
            // ⏏ Kembalikan stok
            $item->produk->increment('stok', $item->kuantitas);
        }

        // ❌ hapus item
        $penjualan->itemPenjualan()->delete();

        // ❌ hapus penjualan
        $penjualan->delete(); 
    });

    return redirect()
        ->route('penjualan.index')
        ->with('success', 'Transaksi berhasil dibatalkan');
}
public function print(int $id)
{
    $sale = Penjualan::with('itemPenjualan.produk')->findOrFail($id);

    return view('penjualan.print', compact('sale'));
}
}
