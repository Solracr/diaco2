@extends('adminlte::page')

@section('content_header')
    
@stop

@section('content')

<!DOCTYPE html>
<html>
<head>
    <style>
        .file-upload-wrapper {
            position: relative;
            width: 250px;
            margin: 20px auto;
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-btn {
            position: relative;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;  /* Color azul predeterminado de Bootstrap */
            color: #ffffff;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .file-upload-btn:hover {
            background-color: #0056b3;  /* Un tono más oscuro de azul */
        }

        #file-chosen {
            margin-top: 10px;
            font-style: italic;
            color: #999;
        }

    </style>
</head>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">                                        
                    <h1>Revisión de comentarios</h1>
                    
                                        
                    <p>Validador: {{ $tipo_ruta }}</p>                        
                        
                    <form method="POST" action="{{ route('contratos.file', ['id' => old('id')]) }}" enctype="multipart/form-data">

                            @csrf
                            <p>Escriba la llave que aparece en su pdf adjunto</p>                            
                            <label for="llave">Ingrese la llave:</label>                            
                            <input type="text" name="id" required> <!-- El usuario escribe el ID aquí -->

                        
                          
                            <div class="form-group">
                                <label for="archivo">Cargar archivo PDF</label>
                                <input type="file" class="form-control" name="archivo" accept=".pdf">
                            </div>
                            <button  type="submit" class="btn btn-primary">Enviar datos</button>                            
                        </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
</html>

@stop