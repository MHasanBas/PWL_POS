<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 50],
            ['barang_id' => 2, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 60],
            ['barang_id' => 3, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 70],
            ['barang_id' => 4, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 80],
            ['barang_id' => 5, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 90],
            ['barang_id' => 6, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 100],
            ['barang_id' => 7, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 110],
            ['barang_id' => 8, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 120],
            ['barang_id' => 9, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 130],
            ['barang_id' => 10, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 140],
            ['barang_id' => 11, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 150],
            ['barang_id' => 12, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 160],
            ['barang_id' => 13, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 170],
            ['barang_id' => 14, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 180],
            ['barang_id' => 15, 'user_id' => 1, 'stok_tanggal' => Carbon::now(), 'stok_jumlah' => 190],
        ];

        DB::table('t_stok')->insert($data);
    }
}
