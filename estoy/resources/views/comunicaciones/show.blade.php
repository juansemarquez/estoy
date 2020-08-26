@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
                    <div class="pull-left">
                        <h2>Comunicación</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('comunicaciones.index') }}">Volver</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <h2>Datos de la comunicación:</h2>
                            <strong>Alumno:</strong> {{$comunicacion->alumno->nombre}} {{ $comunicacion->alumno->apellido }}<br>
                            <strong>Docente:</strong> {{$comunicacion->docente->nombre}} {{ $comunicacion->docente->apellido }}<br>
                            <strong>Fecha: </strong> {{ date('d-m', strtotime($comunicacion->fecha)) }}<br>
                            <strong>Observaciones: </strong> {{ $comunicacion->observaciones ?? "Sin observaciones" }}<br>
                            @can('update', $comunicacion)   
                            <p class="text-center">
                                <a class="btn btn-primary" href="{{route('comunicaciones.edit', $comunicacion)}}">
                                    Modificar la comunicacion
                                </a>
                            </p>
                            @endcan
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
