@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success text-center">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger text-center">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <form action={{ route('crear_comunicacion')}} method="POST" class="text-center">
                       @csrf
                        <div class="form-group">
                       <label for="alumno">¿Quién se comunicó con vos, {{ $nombre }}?</label><br>
                       <input name="alumno" class="form-control form-control-lg" list="datalist" id="input-alumno" autocomplete="off" oninput="tipearNombre(this)" placeholder="Nombre del estudiante">
                       <datalist id="datalist">
                        @foreach ($alumnos as $alumno) 
                            <option data-value="{{$alumno[0]}}" value="{{$alumno[1]}}" />
                        @endforeach
                        </datalist>                    
                        <input type="hidden" name="id_alumno" id="id_alumno">
                        </div>

                        <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" id="fecha" value="{{$hoy}}"><br>
                        </div>

                        <div class="form-group">
                        <input type="text" class="form-control form-control-lg" name="observaciones" id="observaciones" placeholder="Observaciones (opcional)"><br><br>
                        </div>

                        <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Enviar">                  
                        </div>
                    </form>
                    </div>
                </div><br>
                <div class="text-center">
                    <a class="btn btn-primary" href="{{route('comunicaciones.index')}}">Ver todas las comunicaciones</a>
                </div><br>
            <div class="card">
                <div class="card-body">
                    <div id="ultimas" class="text-center">
                        <h3>Últimas comunicaciones que ingresaste:</h3>
                        <ul>
                        @forelse ($comus as $comu) 
                           <li>
                                {{$comu->alumno->apellido}},
                                {{$comu->alumno->nombre}}                                
                                ({{ date('d-m', strtotime($comu->fecha)) }})
                            </li>
                        @empty
                            <li>Aún no cargaste comunicaciones</li>
                        @endforelse
                        </ul>
                    </div>
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
