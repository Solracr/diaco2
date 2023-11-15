@extends('adminlte::page')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Consulta de datos de extranjeros con migraci&oacute;n</h2>     
        </div>
      
    </div>
</div>


<form action="{{ route('migracion.buscar') }}" method="POST">
    @csrf
<div class="row">
    <div class="col-md-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Pasaporte:</strong>
            <input type="text" name="txtpasaporte" placeholder="Escriba el Pasaporte"  class="form-control mb-2">
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Nacionalidad:</strong>
            <br>
            <div class="select">
                <select name="nacionalidad" id="nacionalidad">
                    @foreach($data as $tag)
                        <option value="{{ $tag->GENTILICIO_NAC }}">{{ $tag->GENTILICIO_NAC }}</option>    
                    @endforeach 
                </select>    
            </div>
            
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-md-6 text-left">    
        <button type="submit" class="btn btn-warning">Enviar datos</button>
        <!--a class="btn btn-primary" href="submit"> Enviar Datos</a-->        
    </div>
    
</div>
</form>

@endsection

@section('css')
<style>
:root {
    --background-gradient: linear-gradient(30deg, #f39c12 30%, #f1c40f);
    --gray: #34495e;
    --darkgray: #2c3e50;
  }
  
  select {
    /* Reset Select */
    appearance: none;
    outline: 0;
    border: 0;
    box-shadow: none;
    /* Personalize */
    flex: 1;
    padding: 0 1em;
    color: rgb(24, 18, 18);
    background-color: var(--darkgray);
    background-image: none;
    cursor: pointer;
  }
  /* Remove IE arrow */
  select::-ms-expand {
    display: none;
  }
  /* Custom Select wrapper */
  .select {
    position: relative;
    display: flex;
    width: 20em;
    height: 3em;
    border-radius: .25em;
    background-color: #80b9f1;
    overflow: hidden;
  }
  /* Arrow */
  .select::after {
    content: '\25BC';
    position: absolute;
    top: 0;
    right: 0;
    padding: 1em;
    background-color: #34495e;
    transition: .25s all ease;
    pointer-events: none;
  }
  /* Transition */
  .select:hover::after {
    color: #f39c12;
  }
  
  /* Other styles*/
  body {
    color: rgb(27, 11, 11);
    background: var(--background-gradient);
  }
  h1 {
    margin: 0 0 0.25em;
  }
  a {
    /*font-weight: bold;*/
    color: var(--gray);
    text-decoration: none;
    padding: .25em;
    border-radius: .25em;
    background: rgb(233, 228, 228);
  }
 </style> 
@endsection


@section('js')
<script></script>
@stop