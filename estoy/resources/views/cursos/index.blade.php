@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Estoy - Gestión de cursos</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('cursos.create') }}"> Crear nuevo curso</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Curso</th>
            <th>División</th>
            <th>Descripción</th>
            <th width="280px">Acción</th>
        </tr>
        @foreach ($cursos as $curso)
        <tr>
            <td>{{ $curso->curso }}</td>
            <td>{{ $curso->division }}</td>
            <td>{{ $curso->descripcion }}</td>
            <td>
                <form action="{{ route('cursos.destroy',$curso->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('cursos.show',$curso->id) }}">Mostrar</a>
                    <a class="btn btn-primary" href="{{ route('cursos.edit',$curso->id) }}">Editar</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
