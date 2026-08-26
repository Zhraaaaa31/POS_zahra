<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest as RequestsSearchRequest;
use App\Http\Requests\Produk\StoreRequest;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Produk\UpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Jenis;


class ProdukController extends Controller
{
    public function index(RequestsSearchRequest $request) 
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = $request->input('search');

        if($keyword) {
            $products= Produk::when($keyword, function ($query) use ($keyword){
                $query->where('nama', 'like', '%' .$keyword. '%');
            })
            ->orderBY('nama')
            ->paginate(10)
            ->withQueryString();
        } else {
            $products = Produk::latest()->paginate(10)->withQueryString();
        }

        return view('produk.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('viewAny', Produk::class);
        $jenis = Jenis::orderBy('nama_jenis')->get(); 

        return view('produk.create', compact('jenis')); 


    }
    public function store(StoreRequest $request)
    {
        $this->authorize('viewAny', Produk::class);

        $dataReq = $request->validated();

        $data['user_id'] = Auth::id();
        $data['nama'] = $dataReq['name'];
        $data['jenis_id'] = $dataReq['jenis_id']; 
        $data['harga_beli'] = $dataReq['purchase_price'];
        $data['harga_jual'] = $dataReq['selling_price'];
        $data['stok'] = $dataReq['stock'] ?? true;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }
        Produk::create($data);
        

        return redirect()->route('produk.index')->with('success', 'Product created successfully.');
    }

   public function edit(Produk $produk)
{
    // Gunakan otorisasi 'update' untuk mengecek hak akses edit produk ini
    $this->authorize('update', $produk);
    
    $jenis = Jenis::orderBy('nama_jenis')->get(); 
    return view('produk.edit', compact('produk', 'jenis'));
}

public function update(UpdateRequest $request, Produk $produk)
{
    // 1. Otorisasi
    $this->authorize('update', $produk);

    // 2. Ambil data hasil validasi dari UpdateRequest
    $dataReq = $request->validated();

    // 3. Susun data yang akan diupdate
    $data = [
        'user_id'    => Auth::id(),
        'nama'       => $dataReq['name'],
        'jenis_id'   => $dataReq['jenis_id'],
        'harga_beli' => $dataReq['purchase_price'],
        'harga_jual' => $dataReq['selling_price'],
        'stok'       => $dataReq['stock'],
    ];

    // 4. Jika pengguna mengupload foto baru
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        // Simpan foto baru ke folder 'products'
        $data['foto'] = $request->file('foto')->store('products', 'public');
    }

    // 5. Simpan perubahan ke database (Sangat Penting!)
    $produk->update($data);

    // 6. Redirect setelah berhasil diupdate
    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
}
    public function destroy(Produk $produk)
    { 
        $this->authorize('delete', $produk);

        if($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Product deleted successfully.');
    }

   }
