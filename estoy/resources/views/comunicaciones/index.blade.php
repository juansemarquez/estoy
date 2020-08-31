@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">&nbsp;</div>

                <div class="card-body">
            <div class="pull-left">
                <h2>Estoy - Gestión de comunicaciones</h2>
            </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div>
      <form action="{{route('comunicaciones.listado')}}" method="post">
        @csrf
        <label for="desde">Mostrar una semana desde el:</label> 
        <input type="date" name="desde" id="desde" oninput="habilitar_boton_redirigir(this.value)">
        <input type="submit" class="btn btn-primary" id="boton_redirigir" disabled value="Mostrar">
      </form>
    </div>
<br><br>
    @foreach ($cursos as $unCurso)     
        <h2>{{ $unCurso['descripcion'] }} ({{ ($inicio) }} a {{ $fin }})</h2>
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th>Apellido y Nombre</th>                
                @foreach ($intervalo as $fecha)
                <th class="d-none d-md-table-cell">{{ $fecha }}</th>
                @endforeach
                <th>Total</th>
            </tr>
            @forelse ($comunicaciones[$unCurso->id] as $id => $alumno)
            @php $total = 0; @endphp
            <tr> 
                <td><a href="{{ route('alumnos.show', $id ) }}">
                        {{ $alumno[0]->nombre }} {{ $alumno[0]->apellido }}
                    </a>
                </td>
                @foreach ($intervalo as $unaFecha => $sinUso)
                    @if (!$alumno->firstWhere('fecha','=',$unaFecha))
                        <td class="d-none d-md-table-cell">0</td>
                    @else
                        @php 
                            $cantidad = $alumno->firstWhere('fecha','=',$unaFecha)->cantidad;
                            $total += $cantidad;
                        @endphp
                        <td class="d-none d-md-table-cell">{{$cantidad}}</td>                        
                    @endif
                @endforeach
                <td class="
               @if ($total > 3)
                   bg-success
               @elseif ($total == 3)
                   bg-info
               @elseif ($total == 2)
                   bg-secondary
               @elseif ($total == 1)
                   bg-warning
               @elseif ($total == 0)
                   bg-danger
               @else 
                   bg-light
               @endif
               ">{{$total}}</td>
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
<script>
function habilitar_boton_redirigir(valor) {
    if(valor == null || valor == undefined || valor=='') {
        document.querySelector('#boton_redirigir').disabled = true;
    }
    else {
        document.querySelector('#boton_redirigir').disabled = false;
    }
}
</script>
@endsection
