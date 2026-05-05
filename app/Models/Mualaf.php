<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToDaerah;

class Mualaf extends Model
{
    use HasFactory, BelongsToDaerah;

    protected $fillable = [
        'nama_penuh',
        'no_ic',
        'no_kad_mualaf',
        'tarikh_syahadah',
        'kariah_id',
        'daerah_id',
        'status_khairat',
        'alamat_terkini',
        'waris_islam_nama',
        'waris_islam_tel',
        'waris_non_nama',
        'waris_non_tel',
        'sijil_islam_path',
        'kad_mualaf_path',
        'nama_asal',
        'jantina',
        'bangsa_asal',
        'tarikh_lahir',
        'no_telefon',
        'pekerjaan',
        'status_perkahwinan',
        'bil_anak',
        'tempat_syahadah',
        'status_kematian',
        'is_aktif',
    ];

    protected $casts = [
        'tarikh_syahadah' => 'date',
        'tarikh_lahir' => 'date',
        'status_khairat' => 'boolean',
        'ahli_khairat' => 'boolean',
        'status_kematian' => 'boolean',
        'is_aktif' => 'boolean',
    ];

    public function kariah()
    {
        return $this->belongsTo(Kariah::class, 'kariah_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'mualaf_id');
    }

    public function ziarahLogs()
    {
        return $this->hasMany(ZiarahLog::class, 'mualaf_id');
    }
}
