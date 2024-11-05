<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
//     use HasFactory;

//     // Mendefinisikan nama tabel yang benar
//     protected $table = 'm_level';

//     /**
//      * Definisi relasi ke UserModel
//      *
//      * @return BelongsTo
//      */
//     public function user(): BelongsTo
//     {
//         return $this->belongsTo(UserModel::class, 'level_id', 'level_id');
//     }
// }
// use HasFactory;

// protected $table = 'm_level';
// protected $primaryKey = 'level_id';
// public $timestamps = true;

// protected $fillable = [
//     'level_kode',
//     'level_nama'
// ];
// }
use HasFactory;
    
protected $table = 'm_level'; //Mendefinisikan nama tabel yang digunakan oleh model ini
protected $primaryKey = 'level_id'; //Mendefinisikan primary key dari tabel yang digunakan

protected $fillable = ['level_kode', 'level_nama'];

public function user(): HasMany {
    return $this->hasMany(UserModel::class, 'level_id', 'level_id');
}
}