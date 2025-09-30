<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_jurusan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
