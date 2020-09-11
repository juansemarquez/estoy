<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    protected $fillable = ['nombre_original', 'guardado_como'];

    public function post() 
    {
        return $this->belongsTo(Post::class);
    }
}
