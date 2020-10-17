@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
                <div class="text-center">
                <h1>{{$post->titulo}}</h1>
                <h4>Por {{$post->autor->nombre}} {{$post->autor->apellido}},
                    {{ $post->created_at->format("d/m/Y") }}</h4>
                <a class="btn btn-primary" href="{{ route('posts.index') }}">Volver</a>
                </div>
                </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 p-5" style="white-space: pre-wrap; text-align: justify">{{$post->contenido}}</div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 p-5"> 
            <h3 class="text-center">Archivos adjuntos</h3>
            <ul>
            @forelse ($post->adjuntos as $adjunto)
                <li>
<a href="{{Storage::url('app/adjuntos/'.$adjunto->guardado_como, now()->addMinutes(10))}}">
                    {{ $adjunto->nombre_original}}
                </a></li>
            @empty
                <li>No hay adjuntos</li>
            @endforelse
            </ul>
            </div>
        </div>
        @can('delete', $post)   
        <div class="text-center">
            <a class="btn btn-primary d-inline" href="{{ route('posts.edit',$post->id)}}">Editar</a>
            <form class="d-inline" method="post" action="{{ route('posts.destroy', $post->id)}}"
onsubmit="return confirm('¿Seguro que querés eliminar esta novedad?');">
            @method('DELETE')
            @csrf
            <input type="submit" class="btn btn-danger" value="Eliminar">

            </form>
        </div><hr>  
        @endcan
        <div class="text-center">
            @if ($leido)
                <form action="{{route('lecturas.delete')}}" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id_post" value="{{ $post->id }}">
                    <input type="submit" class="btn btn-warning" value="Marcar como no leído">
                </form>
            @else
                <form action="{{route('lecturas.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="id_post" value="{{ $post->id }}">
                    <input type="submit" class="btn btn-success" value="Marcar como leído">
                </form>
            @endif
        </div><hr>
        <div class="text-center mx-4">
            <h3>Comentarios</h3>
            @forelse ($post->comentarios as $unComentario)
                 <div class="text-justify mx-3">
                     {{$unComentario->texto}}<br>
                     <small>Por {{$unComentario->docentes->nombre}} 
{{$unComentario->docentes->apellido}} el {{$unComentario->created_at->format("d-m-Y")}}</small>
                 @can('forceDelete', $unComentario)   
                 <form action="{{route('comentario.destroy')}}" method="post"
onsubmit="return confirm('¿Seguro que querés eliminar este comentario?');">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id_comentario" value="{{$unComentario->id}}">
                    <small><input type="submit" value="Eliminar comentario"></small>
                 </form>
                 @endcan
                 </div><hr>
            @empty
                <div>
                    No hay comentarios
                </div>
            @endforelse
        </div>
        <div class="text-center">
            <h3>Agregar un comentario</h3>
            <form action="{{route('comentario.store')}}" method="post">
                @csrf
                <input type="hidden" name="id_post" value="{{ $post->id }}">
                <textarea name="texto" rows="8" cols="40" placeholder="Tu comentario">
                </textarea><br>
                <input type="submit" class="btn btn-success" value="Enviar comentario">
            </form>
            
        </div>
        <div class="text-center small">
            <h5>Leído por: </h5>            
            <ul>
               @forelse( $post->lecturas as $docente )
                    <li>{{$docente->nombre}} {{$docente->apellido}}</li>
               @empty
                    <li>Todavía no lo leyó nadie</li>
               @endforelse
            </ul>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
