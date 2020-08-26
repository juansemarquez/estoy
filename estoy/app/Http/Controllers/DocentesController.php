<?php

namespace App\Http\Controllers;

use App\Docentes;
use App\User;
use App\Curso;
use App\Role;
use Illuminate\Http\Request;

class DocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Docentes::class);
        $docentes = Docentes::with('user')->get();
        return view('docentes.index',compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Docentes::class);
        $cursos = Curso::all();
        return view('docentes.create', ['cursos' => $cursos ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Docentes::class);
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'password-repeat' => 'required|same:password'
        ]);

        //Docentes::create($request->all()); //Revisar que cree usuario antes TODO
        $user = new User;

        //Username: primera letra del nombre más apellido (no es unique).
        $n = substr(trim($request['nombre']),0,1).trim($request ['apellido']);
        $user->name = strtolower($n);

        $user->password = bcrypt($request['password']);
        $user->email = trim($request['email']);
        $now = new \Datetime();
        $now->modify("+5 minutes");
        $user->email_verified_at = $now->format('Y-m-d H:i:s');
        $user->save();
        $user->roles()->attach(Role::where('name', 'docente')->first());
        $user->save();
        if (isset($request['es_directivo'])) {
            $user->roles()->attach(Role::where('name', 'directivo')->first());
        }
        $user->save();
        $docente = new Docentes;
        $docente->nombre = $request['nombre'];
        $docente->apellido = $request['apellido'];
        $docente->user()->associate($user);
        $docente->save();
        if (isset($request['curso'])) {
            foreach ($request['curso'] as $id_curso => $noSirve) {
                $curso = Curso::find($id_curso);
                $docente->cursos()->attach($curso);
            }
        }
        
        $docente->save();
        
        return redirect()->route('docentes.index')
                        ->with('success','Docente creado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Docentes  $docentes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $docente = Docentes::find($id);
        $this->authorize('view', $docente);
        $docente->load('cursos');
        $docente->load('user');
        $docente->user->load('roles');
        return view('docentes.show',compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Docentes  $docentes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $docente = Docentes::find($id);
        $this->authorize('update', $docente);
        $docente->load('user');
        $docente->load('cursos');
        if (count($docente->cursos) == 0) {
            $otrosCursos = Curso::all();
        }
        else {       
            //FIXME: Tiene que haber otra forma, hack horrible.
            $array_ids = array(); 
            foreach ($docente->cursos as $curso) {
                $array_ids[] = $curso->id;
            }
            $otrosCursos = Curso::whereNotIn('id', $array_ids)->get();
        }
        return view('docentes.edit',['docente'=>$docente, 'otrosCursos'=>$otrosCursos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Docentes  $docentes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $docente = Docentes::findOrFail($id);
        $this->authorize('update', $docente);
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
        ]);
        $docente->update(['nombre'=>$request['nombre'],
                           'apellido' => $request['apellido']
                          ]);
        if (isset($request['agregar_curso'])) {
            foreach ($request['agregar_curso'] as $id_curso => $noSirve) {
                $curso = Curso::find($id_curso);
                $docente->cursos()->attach($curso);
            }
        }

        if (isset($request['quitar_curso'])) {
            foreach ($request['quitar_curso'] as $id_curso => $noSirve) {
                $curso = Curso::find($id_curso);
                $docente->cursos()->detach($curso);
            }
        }
        $user = $docente->user;
        $user->update(['email' => $request['email']]);
        if (isset($request['es_directivo']) && !$user->hasRole('directivo')) {
            $user->roles()->attach(Role::where('name', 'directivo')->first());
        }
        if (!isset($request['es_directivo']) && $user->hasRole('directivo')) {
            $user->roles()->detach(Role::where('name', 'directivo')->first());
        }

        return redirect()->route('docentes.index')
                 ->with('success','Datos del docente actualizados con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Docentes  $docentes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $docente = Docentes::findOrFail($id);
        $this->authorize('delete', $docente);
        $user = $docente->user;
        $docente->delete();
        $user->delete();
        return redirect()->route('docentes.index')
                        ->with('success','Docente eliminado con éxito');
    }
}
