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
        <div class="text-center">
            <a class="btn btn-primary d-inline" href="{{ route('posts.edit',$post->id)}}">Editar</a>
            <form class="d-inline" method="post" action="{{ route('posts.destroy', $post->id)}}">
            @method('DELETE')
            @csrf
            <input type="submit" class="btn btn-danger" value="Eliminar">
            </form>
    </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
