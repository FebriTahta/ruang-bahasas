<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'profile_id','uraian_id','nilai'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function uraian()
    {
        return $this->belongsTo(Uraian::class);
    }
}
