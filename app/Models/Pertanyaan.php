<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_pertanyaan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
