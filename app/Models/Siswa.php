<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_siswa';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getKelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas');
    }
    public function getJurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan');
    }

}
