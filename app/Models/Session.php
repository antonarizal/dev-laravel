<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_session';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
