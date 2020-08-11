@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Estoy - Gestión de docentes</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('docentes.create') }}"> Crear nuevo docente</a>
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
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th width="280px">Acción</th>
        </tr>
        @foreach ($docentes as $docente)
        <tr>
            <td>{{ $docente->nombre }}</td>
            <td>{{ $docente->apellido }}</td>
            <td>{{ $docente->user->email }}</td>
            <td>
                <form action="{{ route('docentes.destroy',$docente->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('docentes.show',$docente->id) }}">Mostrar</a>
                    <a class="btn btn-primary" href="{{ route('docentes.edit',$docente->id) }}">Editar</a>
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
