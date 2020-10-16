@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="text-center">
                <h2>Estoy - Novedades</h2>
            </div>
            @can('create',App\Post::class)
            <div class="text-center">
                <a class="btn btn-success" href="{{ route('posts.create') }}">Crear novedad</a>
            </div>
            @endcan
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @forelse ($posts as $unPost)
    <a href="{{route('posts.show',$unPost->id)}}" style="text-decoration: none" class="text-dark">
    <div class="post my-1"
        @if ( $lecturas[$unPost->id] )
            style="background-color: #888888"
        @else
            style="background-color: #EEEEEE"
        @endif
        >
            <h1>{{$unPost->titulo}}</h1>
        <h4>Por {{$unPost->autor->nombre}} {{$unPost->autor->apellido}},
        {{ $unPost->created_at->format("d/m/Y") }}
        @if (! $lecturas[$unPost->id] )
           <small><a href="{{route('posts.show',$unPost->id)}}"
                class="text-secondary bg-warning p-2 rounded border">No leído</a></small>
        @endif
        </h4>
    </div>
    </a>
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
