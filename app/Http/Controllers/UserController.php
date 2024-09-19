<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $user =UserModel::with('level')->get();
     return view('user', ['data' => $user]);
    }

    // public function index()
    // {
    //     $users = UserModel::all();
    //     return view('user', ['data' => $users]);
    // }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }


    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }
    
    public function ubah_simpan($id, Request $request)
{
    $user = UserModel::find($id);

    $user->username = $request->username;
    $user->nama = $request->nama;

    if (!empty($request->password)) {
        $user->password = Hash::make($request->password);
    }

    $user->level_id = $request->level_id;

    $user->save();

    return redirect('/user');
}

public function hapus($id)
{
    $user = UserModel::find($id);
    $user->delete();
    return redirect('/user');
}


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
}
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
