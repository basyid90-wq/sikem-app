<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kariah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kariah',
        'zon_daerah',
        'alamat',
        'nama_ajk',
        'no_telefon',
    ];

    public function mualafs()
    {
        return $this->hasMany(Mualaf::class, 'kariah_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'kariah_id');
    }
}
