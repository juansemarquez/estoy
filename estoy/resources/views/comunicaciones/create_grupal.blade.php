@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
                    <div class="pull-left">
                        <h2>Agregar nueva comunicación grupal</h2>
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

<form action="{{ route('store_grupal') }}" method="POST">
    @csrf
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Alumnos de {{$curso->descripcion}}:</strong><br>
                @forelse ($curso->alumnos as $alumno  )
                    <input type="checkbox" name="alumnos[{{$alumno->id}}]" value="{{$alumno->id}}">
                    {{$alumno->apellido}}, {{$alumno->nombre}}<br>
                @empty
                    No hay alumnos en ese curso.
                @endforelse
            </div>

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" value="{{$hoy}}"><br>
        </div>

        <div class="form-group">
            <input type="text" class="form-control form-control-lg"
 name="observaciones" id="observaciones" placeholder="Observaciones (opcional)">
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
