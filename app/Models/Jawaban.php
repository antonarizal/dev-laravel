<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_jawaban';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
