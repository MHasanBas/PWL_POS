<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Barang untuk Supplier 1
            ['kategori_id' => 1, 'barang_kode' => 'B001', 'barang_name' => 'Baby Diapers', 'harga_beli' => 10000, 'harga_jual' => 15000],
            ['kategori_id' => 1, 'barang_kode' => 'B002', 'barang_name' => 'Baby Wipes', 'harga_beli' => 12000, 'harga_jual' => 17000],
            ['kategori_id' => 1, 'barang_kode' => 'B003', 'barang_name' => 'Baby Shampoo', 'harga_beli' => 13000, 'harga_jual' => 18000],
            ['kategori_id' => 1, 'barang_kode' => 'B004', 'barang_name' => 'Baby Lotion', 'harga_beli' => 14000, 'harga_jual' => 19000],
            ['kategori_id' => 1, 'barang_kode' => 'B005', 'barang_name' => 'Baby Powder', 'harga_beli' => 15000, 'harga_jual' => 20000],

            // Barang untuk Supplier 2
            ['kategori_id' => 2, 'barang_kode' => 'B006', 'barang_name' => 'Face Cream', 'harga_beli' => 16000, 'harga_jual' => 21000],
            ['kategori_id' => 2, 'barang_kode' => 'B007', 'barang_name' => 'Face Wash', 'harga_beli' => 17000, 'harga_jual' => 22000],
            ['kategori_id' => 2, 'barang_kode' => 'B008', 'barang_name' => 'Sunscreen Lotion', 'harga_beli' => 18000, 'harga_jual' => 23000],
            ['kategori_id' => 2, 'barang_kode' => 'B009', 'barang_name' => 'Lip Balm', 'harga_beli' => 19000, 'harga_jual' => 24000],
            ['kategori_id' => 2, 'barang_kode' => 'B010', 'barang_name' => 'Hand Cream', 'harga_beli' => 20000, 'harga_jual' => 25000],

            // Barang untuk Supplier 3
            ['kategori_id' => 3, 'barang_kode' => 'B011', 'barang_name' => 'Bread', 'harga_beli' => 21000, 'harga_jual' => 26000],
            ['kategori_id' => 3, 'barang_kode' => 'B012', 'barang_name' => 'Milk', 'harga_beli' => 22000, 'harga_jual' => 27000],
            ['kategori_id' => 3, 'barang_kode' => 'B013', 'barang_name' => 'Butter', 'harga_beli' => 23000, 'harga_jual' => 28000],
            ['kategori_id' => 3, 'barang_kode' => 'B014', 'barang_name' => 'Cheese', 'harga_beli' => 24000, 'harga_jual' => 29000],
            ['kategori_id' => 3, 'barang_kode' => 'B015', 'barang_name' => 'Yogurt', 'harga_beli' => 25000, 'harga_jual' => 30000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
