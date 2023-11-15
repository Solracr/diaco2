@extends('adminlte::page')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Administración de Usuarios</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-warning" href="{{ route('users.create') }}"> Nuevo Usuario</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Estatus</th>
   <th>Roles</th>
   <th width="280px">Acción</th>
 </tr>
 @foreach ($data as $key => $user)
  <tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if($user->status == 1)        
          <label class="badge badge-success">Activo</label>        
      @endif
      @if($user->status == 2)        
        <label class="badge badge-danger">Inactivo</label>        
      @endif
    </td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-info">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-primary" href="{{ route('users.show',$user->id) }}">Mostrar</a>
       <a class="btn btn-warning" href="{{ route('users.edit',$user->id) }}">Editar</a>
       <a class="btn btn-primary" href="{{ route('users.inactivar',$user->id) }}">Inactivar</a>
       <a class="btn btn-success" href="{{ route('users.activar',$user->id) }}">Activar</a>
        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Eliminar Usuario', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>


{!! $data->links() !!}



@endsection