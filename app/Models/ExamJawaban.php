<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamJawaban extends Model
{
    //
    protected $guarded = [];
    protected $table = 'cbt_exam_jawaban';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
