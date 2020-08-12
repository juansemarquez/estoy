<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [ 'curso', 'division', 'descripcion' ];
    public function docentes() {
        return $this->belongsToMany(Docentes::class); 
    }
}
