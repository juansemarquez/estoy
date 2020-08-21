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
                    <form action={{ route('crear_comunicacion')}} method="POST" class="text-center">
                       @csrf
                       <label for="alumno">¿Quién se comunicó con vos, {{ $nombre }}?</label><br>
                       <input name="alumno" list="datalist" id="input-alumno" oninput="tipearNombre(this)">
                       <datalist id="datalist">
                        @foreach ($alumnos as $alumno) 
                            <option data-value="{{$alumno[0]}}" value="{{$alumno[1]}}" />
                        @endforeach
                        </datalist>                    
                        <input type="hidden" name="id_alumno" id="id_alumno">
                        <br> <br>
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" id="fecha" value="{{$hoy}}"><br>
                        <input type="submit" value="Enviar">                  
                    </form>
                    </div>
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
