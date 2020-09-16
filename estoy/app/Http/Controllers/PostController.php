<?php

namespace App\Http\Controllers;

use App\Post;
use App\Adjunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('autor')->orderBy('created_at','desc')->simplePaginate(20);
        return view('posts.index',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create', Post::class);
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            //'adjunto' => 'file'
        ]);

        $post = new Post();
        $post->titulo = $request['titulo'];
        $post->contenido = $request['contenido'];
        $post->autor()->associate(Auth::user()->docentes);
        $post->save();
        foreach ($request->file('adjunto') as $adjunto ) {
            //Armar el nombre del archivo:
            $ahora = new \DateTime;
            $ahora = $ahora->format("YmdHis");
            $nombre = \Str::slug(
 pathinfo($adjunto->getClientOriginalName(),PATHINFO_FILENAME)
            );
            $extension = $adjunto->getClientOriginalExtension();
            $guardar_como = $ahora.'_'.$nombre.".".$extension;

            //Guardar archivo
            try {
              $path = $adjunto->storeAs('adjuntos', $guardar_como);
              //$post->archivo[] = $adjunto;
            }
            catch(\Exception $e) {
                return redirect()->route('posts.index')
                        ->with('error','Novedad guardada. Error con el archivo adjunto.');
            }

            //Guardar en la BD:
            $adj= new Adjunto();
            $adj->nombre_original = $nombre . "." . $extension;
            $adj->guardado_como = $guardar_como;
            $adj->post()->associate($post);
            $adj->save();                        
        }

        return redirect()->route('posts.index')
                        ->with('success','Novedad publicada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //$this->authorize('view', $post);
        $post->load('autor');
        $post->load('adjuntos');
        //TODO: Cargar comentarios y notificaciones
        // $alumno->load(['comunicaciones.docente',
        //            'comunicaciones' => function($q) {
        //        $q->orderBy('fecha','desc');
        //    }]);
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //$this->authorize('create', Post::class);
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'archivo' => 'file'
        ]);

        $post = new Post();
        $post->titulo = $request['titulo'];
        $post->contenido = $request['contenido'];
        if (isset ($request['archivo'])) {
            $post->archivo = $request['archivo'];
        }
        $post->autor()->associate(Auth::user()->docentes);
        $post->save();

        return redirect()->route('posts.index')
                        ->with('success','Novedad actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')
                        ->with('success','Novedad eliminada con éxito');  
    }
}
