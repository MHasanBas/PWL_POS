<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException; 
use App\Models\LevelModel;
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
        $level = LevelModel::select('level_id', 'level_kode', 'level_name');

        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($lvl) { 
                $btn = '<a href="'.url('/level/' . $lvl->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/level/' . $lvl->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/level/'.$lvl->level_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
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