<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException; 
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
        $level = LevelModel::select('level_id', 'level_kode', 'level_name');

        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($lvl) { 
                // $btn = '<a href="'.url('/level/' . $lvl->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/level/' . $lvl->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'.url('/level/'.$lvl->level_id).'">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
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

    public function store (Request $request) {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_name' => 'required|string|max:100'
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_name' => $request->level_name
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil disimpan');
    }

    public function show (string $id) {
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
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_name' => 'required|string|max:100'
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_name' => $request->level_name
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil diubah');
    }

    public function destroy(string $id) {
        $check = LevelModel::find($id);
        if(!$check) { 
            return redirect('/level')-with('error', 'Data level tidak ditemukan');
        }

        try{
            LevelModel::destroy($id); 

            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        }catch (\Illuminate\Database\QueryException $e){

            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

        // Jobsheet 6

        public function create_ajax()
        {
            return view('level.create_ajax');
        }
    
        public function store_ajax(Request $request)
        {
            // cek apakah request berupa ajax
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'level_kode' => 'required|string|min:3|max:10|unique:m_level,level_kode',
                    'level_name' => 'required|string|max: 100',
                ];
                // use Illuminate\Support\Facades\Validator;
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false, // response status, false: error/gagal, true: berhasil
                        'message' => 'Validasi Gagal',
                        'msgField' => $validator->errors(), // pesan error validasi
                    ]);
                }
                LevelModel::create($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil disimpan',
                ]);
            }
            redirect('/');
        }
    
        // Menampilkan halaman form edit level ajax
        public function edit_ajax(string $id)
        {
            $level = LevelModel::find($id);
            return view('level.edit_ajax', ['level' => $level]);
        }
    
        public function update_ajax(Request $request, $id)
        {
            // cek apakah request dari ajax
            if ($request->ajax() || $request->wantsJson()) {
                $rules = [
                    'level_kode' => 'required|max:10|unique:m_level,level_kode,' . $id . ',level_id',
                    'level_name' => 'required|max:100',
                ];
                // use Illuminate\Support\Facades\Validator;
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false, // respon json, true: berhasil, false: gagal
                        'message' => 'Validasi gagal.',
                        'msgField' => $validator->errors() // menunjukkan field mana yang error
                    ]);
                }
                $check = levelModel::find($id);
                if ($check) {
                    $check->update($request->all());
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
    
        public function confirm_ajax(string $id)
        {
            $level = LevelModel::find($id);
            return view('level.confirm_ajax', ['level' => $level]);
        }
    
        public function delete_ajax(Request $request, $id)
        {
            // cek apakah request dari ajax
            if ($request->ajax() || $request->wantsJson()) {
                $level = LevelModel::find($id);
                if ($level) {
                    $level->delete();
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
//             'level_name' => 'required|string|max:100',
//         ]);

//         LevelModel::create([
//             'level_kode' => $request->level_kode,
//             'level_name' => $request->level_name
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
//             'level_name' => 'required|string|max:100',
//         ]);

//         $level = LevelModel::findOrFail($id);
//         $level->update([
//             'level_kode' => $request->level_kode,
//             'level_name' => $request->level_name
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
        // DB::insert('insert into m_level(level_kode, level_name, created_at) values(?, ?, ?)', ['cus', 'Pelanggan', now()]);
        // return 'insert data baru berhasil';

        // $row = DB::update('update m_level set level_name = ? where level_kode = ?', ['Customer', 'cus']);
        // return 'Update data berhasil. Jumlah data yang diupdate: '.$row.' baris';
        
//         $row = DB::delete('delete from m_level where level_name = ? and level_kode = ?', ['Customer', 'cus']);
// return 'Delete data berhasil. Jumlah data yang dihapus: '.$row.' baris';


//         $data = DB::select('select * from m_level');
//         return view('level', ['data' => $data]);
//     }
// }