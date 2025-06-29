<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSpk extends Model
{
    protected $table = 'hasil';
        protected $fillable = [
        'kode_alternatif',
        'nama_alternatif',
        'nilai_s',
        'nilai_v',
        'rank',
    ];
}
