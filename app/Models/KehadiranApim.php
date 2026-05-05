<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranApim extends Model
{
    use HasFactory;

    protected $table = 'kehadiran_apim';

    protected $fillable = [
        'kelas_id',
        'mualaf_id',
        'status_hadir',
        'waktu_rekod',
    ];

    protected $casts = [
        'status_hadir' => 'boolean',
        'waktu_rekod' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasApim::class, 'kelas_id');
    }

    public function mualaf()
    {
        return $this->belongsTo(Mualaf::class, 'mualaf_id');
    }
}
