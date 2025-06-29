<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';
    protected $fillable = ['kode', 'nama_kriteria', 'bobot', 'bobot_ternormalisasi', 'type'];

    protected static function booted()
{
    static::saved(function () {
        \App\Services\SpkService::generate();
    });

    static::deleted(function () {
        \App\Services\SpkService::generate();
    });
}

}
