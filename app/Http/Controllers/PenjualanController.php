<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Product;


class PenjualanController extends Controller
{
    //
    public function index()
    {
        $data_penjualan = Penjualan::orderBy('tanggal', 'desc')->simplePaginate(50);
        $products = Product::all();
        // return view('penjualan');
        return view('penjualan', compact('data_penjualan', 'products'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'pembeli' => 'required|string',
            'nama_produk' => 'required',
            'jumlah' => 'required|integer|min:1',
            'nominal' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($request->nama_produk);

        // Cek apakah jumlah yang dibeli tidak melebihi stok yang tersedia
        if ($request->jumlah > $product->stok_produk) {
            return redirect()->route('penjualan.index')->with('error', 'Jumlah produk yang dibeli melebihi stok yang tersedia.');
        }

        // Tambahkan transaksi
        Penjualan::create([
            'tanggal' => $request->tanggal_transaksi,
            'pembeli' => $request->pembeli,
            'nama_barang' => $product->nama_produk,
            'jumlah' => $request->jumlah,
            'nominal' => $request->nominal,
        ]);

        // Kurangi stok produk
        $product->stok_produk -= $request->jumlah;
        $product->save();

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
