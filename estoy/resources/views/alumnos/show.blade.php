@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Datos del estudiante {{ $alumno->nombre }} {{ $alumno->apellido }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('alumnos.index') }}">Volver</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong> {{ $alumno->nombre }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellido:</strong> {{ $alumno->apellido }}
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Curso:</strong> {{ $alumno->curso->descripcion }}
            </div>
        </div>
        @forelse ($alumno->comunicaciones as $comu)
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>El día {{ date('d-m', strtotime($comu->fecha)) }} se comunicó con 
                {{$comu->docente->nombre}} {{$comu->docente->apellido}}</strong><br>
                <strong>Observaciones:</strong> {{$comu->observaciones ?? "Sin observaciones"}}<br>
                <a href="{{ route('comunicaciones.show', $comu->id) }}">Ver detalles</a>
            </div>
        </div>
        @empty
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>No hay comunciaciones </strong><br>
            </div>
        </div>
        @endforelse

    </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
