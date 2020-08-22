<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('directivo')){
            $cursos = Curso::all();
        }
        else {
            $cursos = Auth::user()->docentes->cursos;
        }
        $cursos->load('alumnos');
        return view('alumnos.index',['cursos'=>$cursos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Alumno::class);
        $cursos = Curso::all();
        return view('alumnos.create',compact('cursos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Alumno::class);
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'curso' => 'required'
        ]);

        $alumno = new Alumno();
        $alumno->nombre = $request['nombre'];
        $alumno->apellido = $request['apellido'];
        $alumno->curso()->associate(Curso::find($request['curso']));
        $alumno->save();

        return redirect()->route('alumnos.index')
                        ->with('success','Alumno creado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno)
    {
        $this->authorize('view', $alumno);
        $alumno->load('curso');
        $alumno->load(['comunicaciones.docente',
                    'comunicaciones' => function($q) {
                $q->orderBy('fecha','desc');
            }]);
        return view('alumnos.show',compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumno $alumno)
    {
        $this->authorize('update', $alumno);
        $alumno->load('curso');
        $cursos = Curso::all();
        return view('alumnos.edit',[ 'alumno'=>$alumno, 'cursos'=>$cursos ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumno $alumno)
    {
        $this->authorize('update', $alumno);
        $request->validate([
            'curso' => 'required',
            'nombre' => 'required',
            'apellido' => 'required'
        ]);

        $alumno->update(
            [ 'nombre'=>$request['nombre'], 'apellido'=>$request['apellido'] ]
        );

        if ($request['curso'] != $alumno->curso->id) {
            $alumno->curso()->dissociate();
            $alumno->curso()->associate(Curso::find($request['curso']));
        }
        
        return redirect()->route('alumnos.index')
                        ->with('success','Alumno actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        $this->authorize('delete', $alumno);
        $alumno->delete();
        return redirect()->route('alumnos.index')
                        ->with('success','Alumno eliminado con éxito');  
    }
}
