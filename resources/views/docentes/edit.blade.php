@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
        <div class="pull-left">
            <h2>Modificar datos del docente</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('docentes.index') }}">Volver</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>¡Epa!</strong> Hay algún error con los datos ingresados.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('docentes.update', $docente->id ) }}" method="POST">
    @csrf
    @method('PUT')

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ $docente->nombre }}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellido:</strong>
                <input type="text" class="form-control" name="apellido" placeholder="Apellido" value="{{ $docente->apellido }}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $docente->user->email }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Agregar cursos:</strong><br>                               
                @foreach ($otrosCursos as $curso)
                    <input type="checkbox" name="agregar_curso[{{ $curso->id }}]">
                    {{ $curso->descripcion }}<br>
                @endforeach

                <strong>Eliminar de estos cursos:</strong><br>                               
                @foreach ($docente->cursos as $curso)
                    <input type="checkbox" name="quitar_curso[{{ $curso->id }}]">
                    {{ $curso->descripcion }}<br>
                @endforeach
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
        </div>

    </div>

</form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
