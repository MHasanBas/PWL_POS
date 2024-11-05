<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{

    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];
    
        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];
    
        $activeMenu = 'level';
    
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($lvl) { 
                $btn  = '<button onclick="modalAction(\'' . url('/level/' . $lvl->level_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $lvl->level_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $lvl->level_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level Baru'
        ];

        $activeMenu = 'level';
        
        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request) {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil disimpan');
    }

    public function show(string $id) {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' =>  'Detail Level'
        ];

        $activeMenu = 'level';

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level'
        ];

        $activeMenu = 'level'; 

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id) {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100'
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil diubah');
    }

    public function destroy(string $id) {
        $check = LevelModel::find($id);
        if(!$check) { 
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id); 
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    public function show_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.show_ajax', ['level' => $level]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|min:3|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            LevelModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan',
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id) {
        $level = LevelModel::find($id);
        return view('level.edit_ajax', ['level' => $level]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|max:10|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $check = LevelModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.confirm_ajax', ['level' => $level]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    public function export_pdf()
    {
        $level = LevelModel::select('level_kode', 'level_nama')->get();

        $pdf = Pdf::loadView('level.export_pdf', ['level' => $level]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();

        return $pdf->stream('Data Level' . date('Y-m-d H:i:s') . '.pdf');
    }
}

//     public function index()
//     {
//         $levels = LevelModel::all();
//         $activeMenu = 'level';
//         $breadcrumb = [
//             'title' => 'Dashboard', 'url',
//             'list' => ['Manajemen Level']
//         ];
//         $page = 'Manajemen Level';

//         return view('layouts.level.index', compact('levels', 'breadcrumb', 'page', 'activeMenu'));
//     }

//     public function create()
//     {
//         $breadcrumb = [
//             'title' => 'Dashboard',
//             'list' => 'Manajemen Level',
//             'list' => ['Tambah Level']
//         ];
//         $page = 'Tambah Level';

//         return view('layouts.level.create', compact('breadcrumb', 'page'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
//             'level_nama' => 'required|string|max:100',
//         ]);

//         LevelModel::create([
//             'level_kode' => $request->level_kode,
//             'level_nama' => $request->level_nama
//         ]);

//         return redirect('/level')->with('success', 'Level berhasil ditambahkan.');
//     }

//     public function edit($id)
//     {
//         $level = LevelModel::findOrFail($id);
//         $breadcrumb = [
//             ['title' => 'Dashboard', 'url' => '/dashboard'],
//             ['title' => 'Manajemen Level', 'url' => '/level'],
//             ['title' => 'Edit Level', 'url' => '#']
//         ];
//         $page = 'Edit Level';

//         return view('layouts.level.edit', compact('level', 'breadcrumb', 'page'));
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
//             'level_nama' => 'required|string|max:100',
//         ]);

//         $level = LevelModel::findOrFail($id);
//         $level->update([
//             'level_kode' => $request->level_kode,
//             'level_nama' => $request->level_nama
//         ]);

//         return redirect('/level')->with('success', 'Level berhasil diubah.');
//     }

//     public function destroy($id)
//     {
//         LevelModel::destroy($id);
//         return redirect('/level')->with('success', 'Level berhasil dihapus.');
//     }
// }


// js 3-4
    // public function index() 
    // {
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['cus', 'Pelanggan', now()]);
        // return 'insert data baru berhasil';

        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'cus']);
        // return 'Update data berhasil. Jumlah data yang diupdate: '.$row.' baris';
        
//         $row = DB::delete('delete from m_level where level_nama = ? and level_kode = ?', ['Customer', 'cus']);
// return 'Delete data berhasil. Jumlah data yang dihapus: '.$row.' baris';


//         $data = DB::select('select * from m_level');
//         return view('level', ['data' => $data]);
//     }
// }