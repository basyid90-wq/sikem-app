<?php

namespace App\Traits;

use App\Models\Daerah;
use App\Models\Scopes\DaerahScope;

trait BelongsToDaerah
{
    public static function bootBelongsToDaerah()
    {
        static::addGlobalScope(new DaerahScope);

        static::creating(function ($model) {
            if (auth()->hasUser() && !auth()->user()->hasRole('super_admin')) {
                if (empty($model->daerah_id)) {
                    $model->daerah_id = auth()->user()->daerah_id;
                }
            }
        });
    }

    public function daerah()
    {
        return $this->belongsTo(Daerah::class, 'daerah_id');
    }
}
