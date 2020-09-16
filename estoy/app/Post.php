<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['titulo','contenido'];

    public function autor() {
        return $this->belongsTo(Docentes::class, 'autor_id');
    }

    public function adjuntos()
    {
        return $this->hasMany(Adjunto::class);
    }
}
