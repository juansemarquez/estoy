<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    public function post() 
    {
        return $this->belongsTo(Post::class);
    }

    public function docentes()
    {
        return $this->belongsTo(Docentes::class);
    }
}
