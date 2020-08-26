@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
        <div class="pull-left">
            <h2>Modificar datos de la comunicación</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('comunicaciones.index') }}">Volver</a>
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
<form action="{{ route('comunicaciones.update', $comunicacion->id ) }}" method="POST">
    @csrf
    @method('PUT')

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
       <div class="form-group">
           <br><label for="alumno">Estudiante:</label><br>
           <input name="alumno" class="form-control form-control-lg" list="datalist"
             id="input-alumno" autocomplete="off" oninput="tipearNombre(this)"
             placeholder="Nombre del estudiante" 
             value="{{$comunicacion->alumno->apellido}}, {{$comunicacion->alumno->nombre}} ({{$comunicacion->alumno->curso->curso}})">
           <datalist id="datalist">
           @foreach ($alumnos as $alumno) 
           <option data-value="{{$alumno->id}}" value="{{$alumno->apellido}}, {{$alumno->nombre}} ({{$alumno->curso->curso}})" />
           @endforeach
           </datalist>                    
           <input type="hidden" name="id_alumno" id="id_alumno" value="{{$comunicacion->alumno->id}}">
       </div><br>

       @can('create',App\Docentes::class)
       <div class="form-group">
           <label for="docente">Docente:</label>
           <select name="docente">
               @foreach ($docentes as $docente)
                   <option value="{{$docente->id}}"
                   @if ($docente->id == $comunicacion->docentes_id)
                       selected>{{ $docente->nombre }} {{$docente->apellido}} </option>
                   @else
                       >{{ $docente->nombre }} {{$docente->apellido}} </option>
                   @endif
               @endforeach    
           </select><br>
       </div>
       @else
           <input type="hidden" name="docente" value="{{$comunicacion->docente->id}}">
       @endcan

       <div class="form-group">
           <label for="fecha">Fecha:</label>
           <input type="date" name="fecha" id="fecha" value="{{ $comunicacion->fecha }}">
       </div><br>

       <div class="form-group">
           <label for="observaciones">Observaciones</label><br>
           <input type="text" class="form-control form-control-lg" name="observaciones" id="observaciones" placeholder="Observaciones (opcional)" value="{{ $comunicacion->observaciones }}"><br>
       </div><br>

       <div class="form-group">
           <input type="submit" class="btn btn-primary" value="Enviar">                  
       </div>


</form>
        @can('delete', $comunicacion)
        <form action="{{ route('comunicaciones.destroy',$comunicacion->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar esta comunicación</button>
        </form>
        @endcan
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function tipearNombre(e) {
     var input = e;
     list = input.getAttribute('list');
     options = document.querySelectorAll('#' + list + ' option');
     hiddenInput = document.getElementById('id_alumno');
     inputValue = input.value;
     //hiddenInput.value = inputValue;

    for(var i = 0; i < options.length; i++) {
        var option = options[i];

        if(option.getAttribute('value') === inputValue) {
            hiddenInput.value = option.getAttribute('data-value');
            break;
        }
    }
    console.log(document.getElementById('id_alumno').value);
}
</script>

@endsection
