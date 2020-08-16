<?php

namespace App\Http\Controllers;

use App\Comunicacion;
use App\Curso;
use App\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComunicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role === 'directivo') {
            $cursos = Curso::all();
        }
        else {
            $cursos = Auth::user()->docentes->cursos;
        }

        //TODO: Todo esto hay que moverlo a otra parte, ¿modelo? 
        
        $hoy = new \DateTime();


        $inicio = new \DateTime();
        $inicio->modify('-6 days');
        // $cursos->load('alumnos.comunicaciones_por_fecha')->where('fecha','>=',$inicio->format("Y-m-d"));
        //$cursos->load('alumnos');
        // $cursos->load(['alumnos','alumnos.comunicaciones_por_fecha']);
        // $cursos->loadMissing('alumnos.comunicaciones_por_fecha');
        //dd($cursos->get());
         
        $comunicaciones = array();
        foreach ($cursos as $curso) {
            $x['curso'] = $curso->descripcion;
            $x['alumno'] = array();
            //$x['comunicaciones'] = 
            $datos =
             \DB::table('alumnos')
                 ->leftjoin('comunicacions','alumnos.id', "=",'comunicacions.alumno_id')
                 ->select('alumnos.id', 
                          'alumnos.apellido', 
                          'alumnos.nombre', 
                          'comunicacions.fecha',
                          \DB::raw('count(comunicacions.id) as cantidad'))
                  ->where([ 
                    ['comunicacions.fecha', '>=', $inicio->format('Y-m-d')],
                    ['alumnos.curso_id', '=', $curso->id]
                    ])
                  ->groupBy('alumnos.id',
                            'alumnos.apellido', 
                            'alumnos.nombre', 
                            'comunicacions.fecha')
                   ->orderBy('alumnos.apellido', 'asc')->orderBy('alumnos.nombre','asc')->orderBy('comunicacions.fecha','asc')
                   ->get();
            $ultima_id = -1; 
            foreach ($datos as $unDato) {
                if ($unDato->id != $ultima_id) {
                    if (isset($unAlumno)) {$x['alumno'][]= $unAlumno;}
                    $unAlumno = array();
                    $unAlumno['id'] = $unDato->id;
                    $ultima_id = $unDato->id;
                    $unAlumno['nombre'] = $unDato->apellido . "," . $unDato->nombre;
                    $unAlumno['fechas'] = array();
                }
                $unAlumno['fechas'][$unDato->fecha] = $unDato->cantidad;                               
            }
            $x['alumno'][]= $unAlumno;
            $unAlumno = null;
            $comunicaciones[] = $x;
            $x = null;
        }
        $cursos = null;
        //dd($comunicaciones);
        
    
        $intervalo = [ $inicio->format("Y-m-d") => $inicio->format("d/m") ];
        while ( $inicio <= $hoy ) {
            $inicio->modify('+1 day');
            $intervalo[$inicio->format("Y-m-d")] = $inicio->format("d/m");
        }
        // dd($intervalo);
        return view('comunicaciones.index',['comunicaciones'=> $comunicaciones,
                                            'intervalo' => $intervalo ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comunicacion  $comunicacion
     * @return \Illuminate\Http\Response
     */
    public function show($id_comunicacion)
    {
        $comunicacion = Comunicacion::with([ 'alumno', 'docente'])
                     ->orderBy('fecha','desc')
                     ->find($id_comunicacion);
        return view('comunicaciones.show',[ 'comunicacion'=> $comunicacion ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comunicacion  $comunicacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Comunicacion $comunicacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comunicacion  $comunicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comunicacion $comunicacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comunicacion  $comunicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comunicacion $comunicacion)
    {
        //
    }
}
