<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaburai extends Model
{
    protected $fillable = [
        'user_id','profile_id','uraian_id','jawabanku'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function uraian()
    {
        return $this->belongsTo(Uraian::class);
    }
}
