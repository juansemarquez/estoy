@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Datos del curso</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('docentes.index') }}">Volver</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Curso:</strong> {{ $curso->curso }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Division:</strong> {{ $curso->division }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>División:</strong> {{ $curso->division }}
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
