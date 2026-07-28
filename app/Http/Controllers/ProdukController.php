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

        return view('produk.create');
    }
    public function store(StoreRequest $request)
    {
        $this->authorize('viewAny', Produk::class);

        $dataReq = $request->validated();

        $data['user_id'] = Auth::id();
        $data['nama'] = $dataReq['name'];
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
        $this->authorize('viewAny', Produk::class);

        return view('produk.edit', compact('produk'));
    }
    public function update(UpdateRequest $request, Produk $produk)
    {
         $this->authorize('viewAny', Produk::class);

        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'nama'       => $dataReq['name'],
            'harga_beli' => $dataReq['purchase_price'],
            'harga_jual' => $dataReq['selling_price'],
            'stok'       => $dataReq['stock'],
        ];

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama (jika ada & memang tersimpan)
            if (
                $produk->foto && 
                Storage::disk('public')->exists($produk->foto)
            ) {
                Storage::disk('public')->delete($produk->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.edit', $produk->id)->with('success', 'Product updated successfully.');
    }

    public function destroy(Produk $produk)
    { 
        $this->authorize('delete', $produk);

        if($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Product delete successfilly');
    }

   }
