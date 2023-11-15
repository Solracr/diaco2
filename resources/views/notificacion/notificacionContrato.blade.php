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
    <h1>Revisión contrato atención requerida</h1>        
    
    <p>Para adjuntar el documento con los cambios realizados debe utilizar el siguiente enlace y la siguiente clave.</p>

    <p>Clave del expediente: {{ $client_name }}</p>
    
    <a href="https://www.diacoenlinea.net/contrato_adhesion/zlkjxcvkla4f54" class="btn btn-green">cargar datos</a>
    <!--a href="https://www.diacoenlinea.net/ticket_validacion/{{ $client_name }}/Servicio_No_conforme" class="btn btn-red">Servicio no Conforme</a-->
  </div>
</body>
</html> 
