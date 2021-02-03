<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kursus_uraian extends Model
{
    protected $table = "kursus_uraian";
    protected $fillable = ['kursus_id','uraian_id'];
}
