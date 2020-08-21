<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $docente = Auth::user()->docentes()->first();
        if (!$docente) { return "No sos docente!"; }
        if (Auth::user()->hasRole('directivo')) {
            $alumnos= \App\Alumno::with('curso')->orderBy('apellido')->get();
        }
        else {
            //FIXME: Debe haber una manera mejor
            $id_cursos = array();
            foreach ($docente->cursos as $curso) {
                $id_cursos[] = $curso->id;
            }
            $alumnos = \App\Alumno::whereIn('curso_id',$id_cursos)->with('curso')->orderBy('apellido')->get();
        }
        $comus = $docente->comunicaciones()->orderBy('fecha','desc')->take(5)->get();
        $datalist=[];
        foreach ($alumnos as $a) {
            $dato = $a->apellido . ", " . $a->nombre . " (" . $a->curso->curso;
            $dato.= $a->curso->division ?" '" . $a->curso->division . "')":")";
            $datalist[] = [$a->id, $dato];
        }
        
        $hoy = (new \DateTime())->format("Y-m-d");
        return view('home', [
            'nombre' => $docente->nombre,
            'alumnos'=>$datalist,
            'hoy'=>$hoy,
            'comus'=>$comus
        ]);
    }
}
