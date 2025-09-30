<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalPertanyaan extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_soal_pertanyaan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
