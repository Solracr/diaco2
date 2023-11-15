@extends('adminlte::page')

@section('content_header')
    
@stop

@section('content')
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
                                        
                    <h1>Evaluación del Ticket</h1>
                    <p>ID: {{ $client_id }}</p>
                    <p>Calificación a Aplicar: {{ $tipo_ruta }}</p>
                        <form method="POST" action="{{ $tipo_ruta == 'Servicio_conforme' ? route('ticket.conformidad', ['client_id' => $client_id]) : route('ticket.no_conformidad', ['client_id' => $client_id]) }}">                        
                        
                            @csrf
                            <!-- Otros campos del formulario si los hay -->
                            <button type="submit" class="btn btn-primary">Enviar calificación</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
