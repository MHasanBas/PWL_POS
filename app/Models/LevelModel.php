<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
use HasFactory;

protected $table = 'm_level';
protected $primaryKey = 'level_id';
public $timestamps = true;

protected $fillable = [
    'level_kode',
    'level_name'
];
}