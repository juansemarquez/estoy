@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
                    <div class="pull-left">
                        <h2>Agregar nuevo estudiante</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('alumnos.index') }}">Volver</a>
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

<form action="{{ route('alumnos.store') }}" method="POST">
    @csrf
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellido:</strong>
                <input type="text" class="form-control" name="apellido" placeholder="Apellido">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>¿En qué curso está el alumno?</strong>
                <select name="curso">
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->id }}">
                        {{ $curso->descripcion }}
                    </option>
                @endforeach
                </select>
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
