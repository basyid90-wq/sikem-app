<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kematian extends Model
{
    use HasFactory;

    protected $table = 'kematians';

    protected $fillable = [
        'mualaf_id',
        'pelapor_id',
        'tarikh_mati',
        'lokasi_mati',
        'status_tuntutan_non',
        'status_kes',
        'nota_log',
        'polis_report_path',
        'surat_wakil_path',
        'kariah_dimaklumkan',
    ];

    protected $casts = [
        'tarikh_mati' => 'date',
        'status_tuntutan_non' => 'boolean',
        'kariah_dimaklumkan' => 'boolean',
    ];

    public function mualaf()
    {
        return $this->belongsTo(Mualaf::class, 'mualaf_id');
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }
}
