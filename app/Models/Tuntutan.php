<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToDaerah;

class Tuntutan extends Model
{
    use HasFactory, BelongsToDaerah;

    protected $table = 'tuntutans';

    protected $fillable = [
        'jenis_tuntutan',
        'reference_id',
        'pemohon_id',
        'daerah_id',
        'jumlah_tuntutan',
        'status_tuntutan',
        'resit_path',
    ];

    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }
}
