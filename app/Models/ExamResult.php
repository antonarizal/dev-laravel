<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_exam_result';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
