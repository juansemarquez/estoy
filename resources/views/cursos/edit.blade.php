@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
        <div class="pull-left">
            <h2>Modificar datos del curso</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('cursos.index') }}">Volver</a>
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
<form action="{{ route('cursos.update', $curso->id ) }}" method="POST">
    @csrf
    @method('PUT')

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Curso:</strong>
                <input type="text" name="curso" class="form-control" placeholder="Curso" value="{{ $curso->curso }}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>División (opcional):</strong>
                <input type="text" class="form-control" name="division"
              placeholder="División (opcional):" value="{{ $curso->division }}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Descripción:</strong>
                <input type="text" class="form-control" name="descripcion"
 placeholder="Ej: Primer año 'B'" value="{{ $curso->descripcion }}">
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
