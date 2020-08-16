@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Estoy - Gestión de comunicaciones</h2>
            </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @foreach ($comunicaciones as $unCurso)     
        <h2>{{ $unCurso['curso'] }}</h2>
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th>Apellido y Nombre</th>                
                @foreach ($intervalo as $fecha)
                <th>{{ $fecha }}</th>
                @endforeach
            </tr>
            
            
            @forelse ($unCurso['alumno'] as $alumno)
            <tr> 
                <td><a href="{{ route('alumnos.show', $alumno['id'] ) }}">
                        {{ $alumno['nombre'] }}
                    </a>
                </td>
                @foreach ($intervalo as $unaFecha => $sinUso)
                    @if (!isset($alumno['fechas'][$unaFecha]))
                        <td>0</td>
                    @else
                        <td>{{ $alumno['fechas'][$unaFecha] }}</td>
                    @endif
                @endforeach
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">No hay estudiantes en este curso</td></tr>
            @endforelse
        </table>
    @endforeach
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection
