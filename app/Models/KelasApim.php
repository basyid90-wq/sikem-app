<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasApim extends Model
{
    use HasFactory;

    protected $table = 'kelas_apim';

    protected $fillable = [
        'guru_id',
        'tajuk_kelas',
        'mod_kelas',
        'pautan_online',
        'masa_mula',
        'masa_tamat',
        'status',
    ];

    protected $casts = [
        'masa_mula' => 'datetime',
        'masa_tamat' => 'datetime',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function kehadirans()
    {
        return $this->hasMany(KehadiranApim::class, 'kelas_id');
    }
}
