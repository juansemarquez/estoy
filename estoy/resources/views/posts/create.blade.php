@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estoy</div>

                <div class="card-body">
                    <div class="pull-left">
                        <h2>Agregar novedad</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('posts.index') }}">Volver</a>
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

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="titulo"><strong>Titulo:</strong></label>
                <input type="text" name="titulo" class="form-control" placeholder="Título" required>
                <p class="small text-danger">(Título descriptivo. Evitá "Información importante", "Dato interesante", etc)</p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="contenido"><strong>Contenido:</strong></label>
                <textarea name="contenido" placeholder="Contenido de la novedad" class="form-control" required></textarea>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="adjunto"><strong>Adjunto:</strong></label>
                <input type="file" 
                accept="audio/*,image/*,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.odt,.ods,.odp"
                name="adjunto" class="form-control">
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
