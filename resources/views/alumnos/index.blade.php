@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Estoy - Gestión de estudiantes</h2>
            </div>
            @can('create',App\Alumno::class)
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('alumnos.create') }}">Crear nuevo estudiante</a>
            </div>
            @endcan
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @foreach ($cursos as $unCurso)     
        <h2>{{ $unCurso->descripcion }}</h2>
        <table class="table table-bordered">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th width="280px">Acción</th>
            </tr>
            @forelse ($unCurso->alumnos as $alumno)
            <tr>
                <td>{{ $alumno->nombre }}</td>
                <td>{{ $alumno->apellido }}</td>
                <td>
                    @can('delete', $alumno)
                    <form action="{{ route('alumnos.destroy',$alumno->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('alumnos.show',$alumno->id) }}">Mostrar</a>
                        <a class="btn btn-primary" href="{{ route('alumnos.edit',$alumno->id) }}">Editar</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    @else
                        <a class="btn btn-info" href="{{ route('alumnos.show',$alumno->id) }}">Mostrar</a>
                    @endcan
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center">No hay estudiantes en este curso</td></tr>
            @endforelse
        </table>
    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
