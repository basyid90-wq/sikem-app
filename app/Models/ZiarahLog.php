<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZiarahLog extends Model
{
    use HasFactory;

    protected $table = 'ziarah_logs';

    protected $fillable = [
        'mualaf_id',
        'user_id',
        'tarikh_ziarah',
        'tujuan',
        'nota_hasil_ziarah',
    ];

    protected $casts = [
        'tarikh_ziarah' => 'date',
    ];

    public function mualaf()
    {
        return $this->belongsTo(Mualaf::class, 'mualaf_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
