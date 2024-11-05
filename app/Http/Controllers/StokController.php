<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        return view('stok.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar Stok',
                'list' => ['Home', 'Stok']
            ],
            'page' => (object) [
                'title' => 'Daftar stok yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'stok',
            'stok' => StokModel::all(),
        ]);
    }

    public function list(Request $request)
    {
        $stoks = StokModel::with(['barang', 'user', 'supplier'])->get();

        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                return '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ' .
                       '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ' .
                       '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('stok.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Stok',
                'list' => ['Home', 'Stok', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah stok baru'
            ],
            'activeMenu' => 'stok',
            'supplier' => SupplierModel::all(),
            'barang' => BarangModel::all(),
            'user' => UserModel::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        StokModel::create($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function show(string $id)
    {
        $stok = StokModel::with(['supplier', 'barang', 'user'])->findOrFail($id);

        return view('stok.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail Stok',
                'list' => ['Home', 'Stok', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail stok'
            ],
            'activeMenu' => 'stok',
            'stok' => $stok,
        ]);
    }

    public function edit(string $id)
    {
        $stok = StokModel::findOrFail($id);

        return view('stok.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit Stok',
                'list' => ['Home', 'Stok', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit stok'
            ],
            'activeMenu' => 'stok',
            'stok' => $stok,
            'supplier' => SupplierModel::all(),
            'barang' => BarangModel::all(),
            'user' => UserModel::all(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        StokModel::findOrFail($id)->update($request->all());

        return redirect('/stok')->with('success', "Data stok berhasil diubah");
    }

    public function destroy(string $id)
    {
        $stok = StokModel::find($id);
        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            $stok->delete();
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // AJAX Methods
    public function create_ajax()
    {
        return view('stok.create_ajax', [
            'supplier' => SupplierModel::all(),
            'barang' => BarangModel::all(),
            'user' => UserModel::all(),
        ]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            StokModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $stok = StokModel::findOrFail($id);

        return view('stok.edit_ajax', [
            'stok' => $stok,
            'supplier' => SupplierModel::all(),
            'barang' => BarangModel::all(),
            'user' => UserModel::all(),
        ]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $stok = StokModel::find($id);
            if ($stok) {
                $stok->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    public function confirm_ajax (string $id) {
        $stok = StokModel::find($id);

        return view('stok.confirm_ajax', ['stok' => $stok]);
    }



    public function show_ajax(string $id)
    {
        $stok = StokModel::find($id);

        if ($stok) {
            return view('stok.show_ajax', ['stok' => $stok]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);

    }

    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax()) {
            $stok = StokModel::find($id);

            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_pdf()
    {
        $stok = StokModel::with(['supplier', 'barang', 'user'])->get();

        $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stok]);
        return $pdf->stream('Data Stok ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
