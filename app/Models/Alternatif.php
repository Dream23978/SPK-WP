<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    protected $fillable = ['nama alternatif','Nama Kriteria','Kriteria', 'bobot','type','normalized_bobot'];
    public function kriteria()
{
    return $this->belongsTo(Kriteria::class);
}

}
