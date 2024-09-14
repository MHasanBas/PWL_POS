<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['supplier_kode' => 'S001', 'suplier_nama' => 'wingsfood', 'supplier_alamat' => 'suhat'],
            ['supplier_kode' => 'S002', 'suplier_nama' => 'infofood', 'supplier_alamat' => 'sulfat'],
            ['supplier_kode' => 'S003', 'suplier_nama' => 'sambalfood', 'supplier_alamat' => 'sukun'],
        ];

        DB::table('m_supplier')->insert($data);
    }
}
