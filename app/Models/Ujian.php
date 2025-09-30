<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_ujian';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function soal()
    {
        return $this->hasOne(\App\Models\Soal::class, 'id','id_soal');
    }

    public function getKelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas');
    }

    public function getJurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan');
    }


}
