<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = ['contenido'];
    public function post() 
    {
        return $this->belongsTo(Post::class);
    }

    public function docentes()
    {
        return $this->belongsTo(Docentes::class);
    }
}
