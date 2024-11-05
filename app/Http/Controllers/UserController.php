<?php

namespace App\Http\Controllers;

use App\Models\LevelModel as ModelsLevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // JS 5
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        // Ambil data level
        $level = ModelsLevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id jika ada
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $btn  = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                        '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = ModelsLevelModel::all();
        $activeMenu = 'user';

        return view('user.create', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $user = UserModel::findOrFail($id);
        $levels = ModelsLevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User',
            'nama' => $user->nama,
        ];

        $activeMenu = 'user';

        return view('user.edit', compact('breadcrumb', 'page', 'user', 'levels', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        $user = UserModel::findOrFail($id);

        $user->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // Jobsheet 6
    public function create_ajax()
    {
        $level = ModelsLevelModel::select('level_id', 'level_nama')->get();
        return view('user.create_ajax')->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa ajax atau ingin JSON
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6'
            ];

            // Gunakan Validator dari Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
            // Simpan data user
            UserModel::create($request->all());

            // Jika berhasil
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan',
            ]);
        }
        // Redirect jika bukan request Ajax
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = ModelsLevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function show_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = ModelsLevelModel::all();

        return view('user.show_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, string $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];

            // Gunakan Validator dari Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
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
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
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
        $user = UserModel::select('level_id', 'username', 'nama')
            ->get();

        $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();

        return $pdf->stream('Data User' . date('Y-m-d H:i:s') . '.pdf');
    }
}





    // public function index()
    // {
    //     $user =UserModel::with('level')->get();
    //  return view('user', ['data' => $user]);
    // }

    // public function index()
    // {
    //     $users = UserModel::all();
    //     return view('user', ['data' => $users]);
    // }


    // js4
//     public function tambah()
//     {
//         return view('user_tambah');
//     }

//     public function ubah($id)
//     {
//         $user = UserModel::find($id);
//         return view('user_ubah', ['data' => $user]);
//     }


//     public function tambah_simpan(Request $request)
//     {
//         UserModel::create([
//             'username' => $request->username,
//             'nama' => $request->nama,
//             'password' => Hash::make($request->password),
//             'level_id' => $request->level_id
//         ]);

//         return redirect('/user');
//     }
    
//     public function ubah_simpan($id, Request $request)
// {
//     $user = UserModel::find($id);

//     $user->username = $request->username;
//     $user->nama = $request->nama;

//     if (!empty($request->password)) {
//         $user->password = Hash::make($request->password);
//     }

//     $user->level_id = $request->level_id;

//     $user->save();

//     return redirect('/user');
// }

// public function hapus($id)
// {
//     $user = UserModel::find($id);
//     $user->delete();
//     return redirect('/user');
// }







// jobsheet 3

    // public function index()
    // {
    //     // Membuat user baru dengan metode create
    //     $user = UserModel::create([
    //         'username' => 'manager11',
    //         'nama' => 'Manager11',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2,
    //     ]);

    //     // Mengubah username
    //     $user->username = 'manager12';

    //     // Menyimpan perubahan ke database
    //     $user->save();

    //     // Mengecek apakah ada perubahan setelah disimpan
    //     $userWasChanged = $user->wasChanged(); // true
    //     $usernameWasChanged = $user->wasChanged('username'); // true
    //     $usernameAndLevelIdChanged = $user->wasChanged(['username', 'level_id']); // true
    //     $namaWasChanged = $user->wasChanged('nama'); // false

    //     // Debugging untuk melihat hasil wasChanged setelah perubahan
    //     dd($user->wasChanged(['nama', 'username'])); // true
    // }
// }
//     public function index()
//     {
//         // Membuat user baru dengan metode create
//         $user = UserModel::create([
//             'username' => 'manager55',
//             'nama' => 'Manager55',
//             'password' => Hash::make('12345'),
//             'level_id' => 2,
//         ]);

//         // Mengubah username setelah pembuatan
//         $user->username = 'manager56';

//         // Mengecek apakah properti 'username' sudah berubah
//         $isDirtyUsername = $user->isDirty('username'); // true
//         $isDirtyNama = $user->isDirty('nama'); // false
//         $isDirtyBoth = $user->isDirty(['nama', 'username']); // true

//         // Mengecek apakah properti 'username' dan 'nama' bersih (tidak berubah)
//         $isCleanUsername = $user->isClean('username'); // false
//         $isCleanNama = $user->isClean('nama'); // true
//         $isCleanBoth = $user->isClean(['nama', 'username']); // false

//         // Menyimpan perubahan ke database
//         $user->save();

//         // Setelah save, semua perubahan tersimpan
//         $isDirtyAfterSave = $user->isDirty(); // false
//         $isCleanAfterSave = $user->isClean(); // true

//         // Debugging untuk melihat hasil isDirty setelah disimpan
//         dd($isDirtyAfterSave);
//     }
// }

    // public function index()
    // {
    //     $user = UserModel::firstOrCreate(
    //         [
    //         'username' => 'manager33', 
    //         'nama' => 'Manager Tiga Tiga',
    //         'password' =>Hash::make('12345'),
    //         'level_id' => 2
    //     ],
            // [
            //     'nama' => 'Manager Dua Dua',
            //     'password' => Hash::make('12345'),
            //     'level_id' => 2,
            // ]
        // );

        // Mengirim data ke view
        // $user->save();
        // return view('user', ['data' => $user]);

        // $user = UserModel::find(1);
        // $user = UserModel::where('level_id', 1)->first();
        // $user = UserModel::firstWhere('level_id', 1);
        // $user = UserModel::findOr(20,['username','nama'], function () {
        //     abort(404);
        // });
        // $user = UserModel::findOrFail(1);
        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        // $userCount = UserModel::where('level_id', 2)->count();
        // dd($user);
        // return view('user', ['userCount' => $userCount]);
    // }

// {
//     public function index()
//     {
//         $data =[
//             'level_id' => 2,
//             'username' => 'manager_tiga',
//             'nama' => 'Manager 3',
//             'password' => Hash::make('12345'),
//         ];
//         UserModel::create($data);


        // $data = [
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan ',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 4
        // ];
        // UserModel::insert($data);
        
        // tambah data user dengan Eloquent Model
        // $data = [
        //     'nama' => 'Pelanggan Pertana',
        // ];
        // UserModel::where('username', 'customer-1')->update($data); // update data user
        
        // coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
//         return view('user', ['data' => $user]);
//     }   
// }    