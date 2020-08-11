<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docentes extends Model
{
   protected $table = "docentes";
   protected $fillable = ['nombre', 'apellido'];
   //protected $nombre;
   //protected $apellido;

   public function user()
   {
       return $this->belongsTo('App\User');
   }
   public function cursos() {
       return $this->belongsToMany(Curso::class);
   }
   public function cursosQueNoTiene() {
       return Curso::all()->diff($this->cursos());
   }
}
