<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uraian extends Model
{
    protected $fillable = [
        'user_id','kelas_id','mapel_id','judul','soal','start','end','status','slug'
    ];

    public function kursus()
    {
        return $this->belongsToMany(Kursus::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jawaburai()
    {
        return $this->hasMany(Jawaburai::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    
}


