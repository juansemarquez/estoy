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
    @foreach ($cursos as $unCurso)     
        <h2>{{ $unCurso['descripcion'] }}</h2>
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th>Apellido y Nombre</th>                
                @foreach ($intervalo as $fecha)
                <th>{{ $fecha }}</th>
                @endforeach
            </tr>
            
            @forelse ($comunicaciones[$unCurso->id] as $id => $alumno)
            <tr> 
                <td><a href="{{ route('alumnos.show', $id ) }}">
                        {{ $alumno[0]->nombre }} {{ $alumno[0]->apellido }}
                    </a>
                </td>
                @foreach ($intervalo as $unaFecha => $sinUso)
                    @if (!$alumno->firstWhere('fecha','=',$unaFecha))
                        <td>0</td>
                    @else
                        <td>{{ $alumno->firstWhere('fecha','=',$unaFecha)->cantidad }}</td>
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
