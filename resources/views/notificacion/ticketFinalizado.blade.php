<!DOCTYPE html>
<html>
<head>
    <style>
        div {          
          width: 100%;
          padding: 5px;          
        }
        p {
                font-family: arial, verdana, sans-serif; 
                font-size: 14 px;
            }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn-green {
            background-color: green;
        }

        .btn-red {
            background-color: red;
        }
    </style>
  <title>Sistema de Notificaciones</title>
</head>
<body>                           
  <div> 
    <!--img src="https://gestordequejas.diaco.gob.gt/assets/logo.c4508b5d.png" width="300" height="90" alt="Logo"!-->
    <br>
    <h1>Ticket {{ $client_name }} Finalizado exitosamente</h1>        
    <p>Gracias por utilizar este servicio.</p>
    <p>Le invitamos a seleccionar nuestro servicio como no conforme en caso de existir algun inconveniente.</p>
    
    <a href="https://www.diacoenlinea.net/ticket_validacion/{{ $client_name }}/Servicio_conforme" class="btn btn-green">Servicio Conforme</a>
    <a href="https://www.diacoenlinea.net/ticket_validacion/{{ $client_name }}/Servicio_No_conforme" class="btn btn-red">Servicio no Conforme</a>
  </div>
</body>
</html> 
