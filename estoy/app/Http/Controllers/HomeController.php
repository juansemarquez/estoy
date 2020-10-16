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
        $docente = Auth::user()->docentes;
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
        $comus = $docente->comunicaciones()->orderBy('created_at','desc')->take(5)->get();
        $datalist=[];
        foreach ($alumnos as $a) {
            $dato = $a->apellido . ", " . $a->nombre . " (" . $a->curso->curso;
            $dato.= $a->curso->division ?" '" . $a->curso->division . "')":")";
            $datalist[] = [$a->id, $dato];
        }
        
        $hoy = (new \DateTime())->format("Y-m-d");

        // Obtener la cantidad de novedades no leidas:
        $noLeidos = $docente->cantidad_posts_no_leidos();


        return view('home', [
            'nombre' => $docente->nombre,
            'alumnos'=>$datalist,
            'hoy'=>$hoy,
            'comus'=>$comus,
            'noLeidos'=>$noLeidos
        ]);
    }
    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'id_alumno' => 'required|numeric',
            'fecha' => 'date|required',
        ]);
        $alumno = \App\Alumno::findOrFail($request['id_alumno']);
        $fecha = new \DateTime($request['fecha']);

        $c = new \App\Comunicacion();
        $c->fecha = $fecha;
        $c->observaciones = isset($request['observaciones'])?$request['observaciones']:null;
        $c->alumno()->associate($alumno);
        $c->docente()->associate(Auth::user()->docentes()->first());
        $this->authorize('create',$c);
        if(\App\Comunicacion::where('alumno_id',$c->alumno->id)
            ->where('docente_id',$c->docente->id)
            ->where('fecha',$c->fecha)
            ->count() === 0 )  {
                $c->save();
        return redirect()->route('home')
                        ->with('success','Comunicación guardada con éxito.');
        }
        else {
            return redirect()->route('home')
                        ->with('error','Ya había una comunicación guardada ese día entre ese estudiante y ese docente.');
        }
        
    }
}
