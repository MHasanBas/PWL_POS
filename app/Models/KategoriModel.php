<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriModel extends Model
{
//     use HasFactory;

//     protected $table = 'm_kategori';
//     protected $primaryKey = 'kategori_id';
//     /**
//      * The attributes that are mass assignable.
//      * 
//      * @var array
//      */
//     protected $fillable = ['kategori_kode', 'kategori_nama'];
// }


    use HasFactory;

    protected $table = 'm_kategori'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'kategori_id'; //Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['kategori_kode', 'kategori_nama'];

    public function barang(): HasMany {
        return $this->hasMany(BarangModel::class, 'kategori_id', 'kategori_id');
    }
}