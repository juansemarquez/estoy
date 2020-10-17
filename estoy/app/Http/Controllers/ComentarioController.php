<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_post' => 'required',
            'texto' => 'required'
        ]);
 
        $comentario = new Comentario();
        $comentario->docentes()->associate(Auth::user()->docentes);
        $comentario->post()->associate(Post::find($request['id_post']));
        $comentario->texto = $request['texto'];
        $comentario->save();

        return redirect()->route('posts.show', $request['id_post'])
                        ->with('success','Comentario publicado exitosamente.');
    }
    
    public function destroy(Request $request) {
        $request->validate([
            'id_comentario' => 'required',
        ]);
        $comentario = Comentario::find($request['id_comentario']);
        $id_post = $comentario->post_id;
        $comentario->delete();
        return redirect()->route('posts.show', $id_post)
                        ->with('success','Comentario eliminado');
    }
}
