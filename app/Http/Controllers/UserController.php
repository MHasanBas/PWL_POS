<?php

namespace App\Http\Controllers;

use App\Models\LevelModel as ModelsLevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;

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
            $btn = '<a href="' . url('/user', $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user', $user->user_id) . '">'
                . csrf_field()
                . method_field('DELETE')
                . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
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

        return view('user.show', compact('breadcrumb', 'page', 'user', 'activeMenu'));
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
