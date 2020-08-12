@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Datos del docente</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('docentes.index') }}">Volver</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong> {{ $docente->nombre }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellido:</strong> {{ $docente->apellido }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                @if (count($docente->cursos) > 0)        
                    <strong>Cursos:</strong>                
                    <ul>
                        @foreach ($docente->cursos as $curso)
                            <li>{{ $curso->descripcion }}</li>
                        @endforeach
                    </ul>
                @else
                    <strong>No asignado a ningún curso</strong>
                @endif
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Roles:</strong> <br>
                @foreach ($docente->user->roles as $rol)
                   {{ $rol->description }}<br>
                @endforeach
            </div>
        </div>
        
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
