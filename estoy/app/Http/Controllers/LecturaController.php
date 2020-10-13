<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Lectura;

class LecturaController extends Controller
{
    public function store(Request $request)
    {
        //$this->authorize('create', Post::class);
        $request->validate([
            'id_post' => 'required',
        ]);
 
        $lectura = new Lectura();
        $lectura->docentes()->associate(Auth::user()->docentes);
        $lectura->post()->associate(Post::find($request['id_post']));
        $lectura->save();

        return redirect()->route('posts.show', $request['id_post'])
                        ->with('success','Novedad marcada como leída.');
    }

    public function destroy(Request $request) {
        $request->validate([
            'id_post' => 'required',
        ]);
        $lectura = Lectura::where('post_id', $request['id_post'])->where('docentes_id', Auth::user()->docentes->id)->first();
        $lectura->delete();
        return redirect()->route('posts.show', $request['id_post'])
                        ->with('success','Novedad marcada como no leída.');
    }
}
