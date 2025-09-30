<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunci extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_kunci';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
