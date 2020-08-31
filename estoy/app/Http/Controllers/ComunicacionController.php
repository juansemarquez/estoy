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
    public function index() {
        return $this->listado();
    }

    public function listado_desde(Request $request)
    {
        $request->validate([
            'desde' => 'required|date'
        ]);
        return $this->listado($request['desde']);
    }


    public function listado($inicio = null)
    {
        if(Auth::user()->hasRole('directivo')){
            $cursos = Curso::all();
        }
        else {
            $cursos = Auth::user()->docentes->cursos;
        }

        //TODO: Todo esto hay que moverlo a otra parte, ¿modelo? 
        

        if (is_null($inicio)) {
            $inicio = new \DateTime(date("Y-m-d"));
            $inicio->modify('-6 days');
            $fin = new \DateTime(date("Y-m-d"));
        }
        else {
            $fin = new \DateTime($inicio);
            $fin->modify('+6 days');
            $inicio = new \DateTime($inicio);
            
            
        }
        // $cursos->load('alumnos.comunicaciones_por_fecha')->where('fecha','>=',$inicio->format("Y-m-d"));
        //$cursos->load('alumnos');
        // $cursos->load(['alumnos','alumnos.comunicaciones_por_fecha']);
        // $cursos->loadMissing('alumnos.comunicaciones_por_fecha');
        // dd($cursos);
         
        $id_cursos = [];
        foreach ($cursos as $curso) {
            $id_cursos[] = $curso->id;
        }

        $ultimas = Comunicacion::where('fecha','>=', $inicio->format('Y-m-d'));
        $datos = \DB::table('alumnos')
                 ->leftJoinSub($ultimas,'c', function($join) {
                     $join->on('alumnos.id', "=",'c.alumno_id');
                 })
                 ->select('alumnos.id', 
                          'alumnos.curso_id',
                          'alumnos.apellido', 
                          'alumnos.nombre', 
                          'c.fecha',
                          \DB::raw('count(c.id) as cantidad'))
                  ->whereIn('alumnos.curso_id', $id_cursos)
                  ->groupBy('alumnos.curso_id',
                            'alumnos.id',
                            'alumnos.apellido', 
                            'alumnos.nombre', 
                            'c.fecha')
                  ->orderBy('alumnos.curso_id')
                  ->orderBy('alumnos.apellido', 'asc')
                  ->orderBy('alumnos.nombre','asc')
                  ->orderBy('c.fecha','asc')
                  ->get();
        $datos = $datos->groupBy(['curso_id','id']);        
        $intervalo = [ $inicio->format("Y-m-d") => $inicio->format("d/m") ];
        while ( $inicio < $fin ) {
            $inicio->modify('+1 day');
            $intervalo[$inicio->format("Y-m-d")] = $inicio->format("d/m");
        }
        return view('comunicaciones.index',['comunicaciones'=> $datos,
                                            'cursos' => $cursos,
                                            'intervalo' => $intervalo,
                                            'inicio' => reset($intervalo),
                                            'fin' => end($intervalo)
                                         ]);
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
    public function edit($comunicacion)
    {
        $comunicacion = Comunicacion::find($comunicacion)->load(['docente','alumno']);
        $this->authorize('update',$comunicacion);
        $comunicacion->load(['alumno','docente']); 
        if(Auth::user()->hasRole('directivo')){
            $docentes = \App\Docentes::all();
            $alumnos= \App\Alumno::with('curso')->orderBy('apellido')->get();
        }
        else {
            $docentes = [ $comunicacion->docente ];

            //FIXME: Debe haber una manera mejor
            $id_cursos = array();
            foreach ($comunicacion->docente->cursos as $curso) {
                $id_cursos[] = $curso->id;
            }
            $alumnos = \App\Alumno::whereIn('curso_id',$id_cursos)->with('curso')->orderBy('apellido')->get();
        }
            
        return view('comunicaciones.edit',[ 'comunicacion' => $comunicacion,
                                            'docentes' => $docentes,
                                            'alumnos' => $alumnos ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comunicacion  $comunicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comunicacion)
    {
        $comunicacion = Comunicacion::find($comunicacion);
        $this->authorize('update',$comunicacion);

        $request->validate([
            'id_alumno' => 'required|numeric',
            'fecha' => 'required|date',
            'docente' => 'required|numeric'
        ]);

        $fecha = new \DateTime($request['fecha']);
        $comunicacion->update([
            'fecha' => $fecha,
            'observaciones' => $request['observaciones']
        ]);
        if ($comunicacion->alumno_id != $request['id_alumno']) {
            $alumno = \App\Alumno::findOrFail($request['id_alumno']);
            $comunicacion->alumno()->dissociate();
            $comunicacion->alumno()->associate($alumno);
        }
        if(Auth::user()->hasRole('directivo') && 
                          $comunicacion->docentes_id != $request['docente'] ) {
            $docente = \App\Docentes::findOrFail($request['docente']);
            $comunicacion->docente()->dissociate();
            $comunicacion->docente()->associate($docente);
        }
        $comunicacion->save();     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comunicacion  $comunicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($comunicacion)
    {
        $comunicacion = Comunicacion::find($comunicacion);
        $this->authorize('delete',$comunicacion);
        $comunicacion->delete();
        return redirect()->route('home')
                        ->with('success','Comunicación eliminada con éxito');  
    }
}
