<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunicacion extends Model
{
    protected $fillable = ['observaciones', 'fecha'];

    public function alumno() {
        return $this->belongsTo(Alumno::class);
    }

    public function docente() {
        return $this->belongsTo(Docentes::class);
    }
}
