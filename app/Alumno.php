<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = [ 'nombre', 'apellido' ];

    public function curso() {
        return $this->belongsTo(Curso::class);
    } 
}
