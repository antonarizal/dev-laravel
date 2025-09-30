<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_soal';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function getUjian()
    {
        return $this->belongsTo('App\Models\Ujian', 'ujian_id', 'id');
    }
    public function getJurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan');
    }
    public function getKelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas');
    }
}
