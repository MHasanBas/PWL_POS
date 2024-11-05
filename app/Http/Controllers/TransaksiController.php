<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiDetailModel;
use App\Models\TransaksiModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi',
            'list' => ['Home', 'Transaksi']
        ];

        $page = (object) [
            'title' => 'Daftar transaksi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'transaksi';

        $transaksi = TransaksiModel::all();

        return view('transaksi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'transaksi' => $transaksi, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $transaksis = TransaksiModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')->with('user');

        return DataTables::of($transaksis)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('aksi', function ($transaksi) {  // menambahkan kolom aksi 
                // $btn  = '<a href="' . url('/transaksi/' . $transaksi->transaksi_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/transaksi/' . $transaksi->transaksi_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' .
                //     url('/transaksi/' . $transaksi->transaksi_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<a href="' . url('/transaksi/' . $transaksi->penjualan_id . '/export_detail_pdf') . '" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Detail Transaksi</a> ';
                $btn  .= '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->penjualan_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->penjualan_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->penjualan_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi',
            'list' => ['Home', 'Transaksi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah transaksi baru'
        ];

        $user = UserModel::all();
        $barang = BarangModel::select('id_barang', 'nama_barang');
        $activeMenu = 'transaksi';

        return view('transaksi.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user, 'barang' => $barang]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:100',
            'penjualan_kode' => 'required|string|max:20|min:3|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date',
        ]);

        TransaksiModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal
        ]);

        return redirect('/transaksi')->with('success', 'Data transaksi berhasil disimpan');
    }

    public function show(string $id)
    {
        $transaksi = TransaksiModel::with(['transaksiDetail.barang', 'user'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Transaksi',
            'list' => ['Home', 'Transaksi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail transaksi'
        ];

        $activeMenu = 'transaksi';

        return view('transaksi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'transaksi' => $transaksi, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $transaksi = TransaksiModel::with(['transaksiDetail.barang', 'user'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Transaksi',
            'list' => ['Home', 'Transaksi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit transaksi'
        ];

        $activeMenu = 'transaksi';

        return view('transaksi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'transaksi' => $transaksi, 'transaksi' => $transaksi, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:100',
            'penjualan_kode' => 'required|string|max:20|min:3|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
            'penjualan_tanggal' => 'required|date',
        ]);

        TransaksiModel::find($id)->update([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal
        ]);

        return redirect('/transaksi')->with('success', "Data transaksi berhasil diubah");
    }

    public function destroy(string $id)
    {
        $check = TransaksiModel::find($id);
        if (!$check) {
            return redirect('/transaksi')->with('error', 'Data transaksi tidak ditemukan');
        }

        try {
            TransaksiModel::destroy($id);

            return redirect('/transaksi')->with('success', 'Data transaksi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/transaksi')->with('error', 'Data transaksi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function show_ajax(string $id)
    {
        $transaksi = TransaksiModel::with(['user', 'transaksiDetail.barang'])->find($id);

        return view('transaksi.show_ajax', ['transaksi' => $transaksi]);
    }

    public function create_ajax()
    {
        $user = UserModel::select('user_id', 'name')->get();
        $barang  = BarangModel::select('barang_id', 'barang_nama')->get();

        return view('transaksi.create_ajax')->with('user', $user)->with('barang', $barang);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|integer',
                'pembeli' => 'required|string|max:100',
                'penjualan_kode' => 'required|string|max:20|min:3|unique:t_penjualan,penjualan_kode',
                'penjualan_tanggal' => 'required|date',
                'transaksi_details.*.barang_id' => 'required|integer',
                'transaksi_details.*.jumlah' => 'required|integer',
                'transaksi_details.*.harga' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Create the transaction
            $transaksi = TransaksiModel::create($request->only(['user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal']));

            // Add transaction details
            foreach ($request->transaksi_details as $detail) {
                TransaksiDetailModel::create([
                    'penjualan_id' => $transaksi->penjualan_id,
                    'barang_id' => $detail['barang_id'],
                    'harga' => $detail['harga'],
                    'jumlah' => $detail['jumlah'],
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Transaksi berhasil disimpan'
            ]);
        }

        return redirect('/');
    }


    public function edit_ajax(string $id)
    {
        $transaksi = TransaksiModel::with(['transaksiDetail.barang'])->find($id);
        $user = UserModel::select('user_id', 'name')->get();
        $barang  = BarangModel::select('barang_id', 'barang_nama')->get();

        // dd($transaksi->user);
        return view('transaksi.edit_ajax', ['transaksi' => $transaksi, 'user' => $user, 'barang' => $barang]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|integer',
                'pembeli' => 'required|string|max:100',
                'penjualan_kode' => 'required|string|max:20|min:3|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
                'penjualan_tanggal' => 'required|date',
                'transaksi_details.*.barang_id' => 'required|integer',
                'transaksi_details.*.jumlah' => 'required|integer',
                'transaksi_details.*.harga' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $transaksi = TransaksiModel::find($id);
            if (!$transaksi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }

            // Update main transaksi data
            $transaksi->update($request->only(['user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal']));

            // Process transaction details (updating, deleting, and adding new)
            $existingDetailIds = $transaksi->transaksiDetail->pluck('detail_id')->toArray();
            $incomingDetailIds = array_keys($request->transaksi_details);

            // Delete removed details
            $toDelete = array_diff($existingDetailIds, $incomingDetailIds);
            TransaksiDetailModel::destroy($toDelete);

            // Update or create details
            foreach ($request->transaksi_details as $detailId => $detailData) {
                if (in_array($detailId, $existingDetailIds)) {
                    // Update existing detail
                    TransaksiDetailModel::where('detail_id', $detailId)->update($detailData);
                } else {
                    // Add new detail
                    TransaksiDetailModel::create([
                        'penjualan_id' => $transaksi->penjualan_id,
                        'barang_id' => $detailData['barang_id'],
                        'harga' => $detailData['harga'],
                        'jumlah' => $detailData['jumlah'],
                    ]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data transaksi berhasil diubah.',
            ]);
        }
    }


    public function confirm_ajax(string $id)
    {
        $transaksi = TransaksiModel::with(['user', 'transaksiDetail.barang'])->find($id);

        return view('transaksi.confirm_ajax', ['transaksi' => $transaksi]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $transaksi = TransaksiModel::find($id);

            if ($transaksi) {
                $transaksi->delete();
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
            return redirect('/');
        }
    }

    public function export_pdf()
    {
        $transaksi = TransaksiModel::select('user_id', 'penjualan_kode', 'penjualan_tanggal', 'pembeli')
            ->with('user')
            ->get();

        $pdf = Pdf::loadView('transaksi.export_pdf', ['transaksi' => $transaksi]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();

        return $pdf->stream('Data Transaksi' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function export_detail_pdf($id)
    {
        $transaksi = TransaksiModel::with(['user', 'transaksiDetail.barang'])->find($id);

        // dd($transaksi->transaksiDetail);

        $pdf = Pdf::loadView('transaksi.export_detail_pdf', ['transaksi' => $transaksi]);

        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();

        return $pdf->stream('Data Transaksi' . date('Y-m-d H:i:s') . '.pdf');
    }
}