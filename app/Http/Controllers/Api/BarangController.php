<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;


class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }
    public function store(Request $request)
    {
        $barang = BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'image' => $request->image->hashName()
        ]);
        return response()->json($barang, 201);
    }
    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }
    public function update(Request $request, BarangModel $barang)
    {
        $barang->update([
            'kategori_id' => $request->kategori_id ?? $barang->kategori_id,
            'barang_kode' => $request->barang_kode ?? $barang->barang_kode,
            'barang_nama' => $request->barang_nama ?? $barang->barang_nama,
            'harga_beli' => $request->harga_beli ?? $barang->harga_beli,
            'harga_jual' => $request->harga_jual ?? $barang->harga_jual,
            'image' => $request->image->hashName() ?? $barang->image
        ]);
        return BarangModel::find($barang);
    }
    public function destroy(BarangModel $barang)
    {
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}