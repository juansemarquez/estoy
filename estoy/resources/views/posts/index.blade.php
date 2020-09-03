@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Estoy - Novedades</h2>
            </div>
            <!-- can('create',App\Post::class) -->
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('posts.create') }}">Crear novedad</a>
            </div>
            <!-- endcan -->
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @forelse ($posts as $unPost)
    <div class="post">
        <a href="{{route('posts.show',$unPost->id)}}">
            <h1>{{$unPost->titulo}}</h1>
        </a>
        <h4>Por {{$unPost->autor->nombre}} {{$unPost->autor->apellido}},
        {{ $unPost->created_at->format("d/m/Y") }}</h4>
    </div>
    <hr>
    @empty
    <div class="post">
        <h1>No hay ninguna novedad publicada</h1>
    </div>
    @endforelse
    {{ $posts->links() }}
        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
