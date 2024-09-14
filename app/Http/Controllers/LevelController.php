<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index() 
    {
        // DB::insert('insert into m_level(level_kode, level_name, created_at) values(?, ?, ?)', ['cus', 'Pelanggan', now()]);
        // return 'insert data baru berhasil';

        // $row = DB::update('update m_level set level_name = ? where level_kode = ?', ['Customer', 'cus']);
        // return 'Update data berhasil. Jumlah data yang diupdate: '.$row.' baris';
        
//         $row = DB::delete('delete from m_level where level_name = ? and level_kode = ?', ['Customer', 'cus']);
// return 'Delete data berhasil. Jumlah data yang dihapus: '.$row.' baris';


        $data = DB::select('select * from m_level');
        return view('level', ['data' => $data]);
    }
}