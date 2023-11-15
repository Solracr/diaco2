<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        p {
        margin-top: 100px;
        margin-bottom: 100px;
        margin-right: 150px;
        margin-left: 80px;
        }
    </style>
    </head>
    <body>
        <div id="diverror" style="display: none">
            <div class="alert alert-danger" role="alert">
                ERROR Esta Acción no esta permitida.
            </div>
        </div>
        <div id="main" style="none"  class="text-center">
            <img src="img/logo.png" alt="Logo">
                <p><b>                    
                        MINISTERIO DE ECONOMIA -DIACO-
                </b></p>                
                <div id="valido" style="display: none" class="alert alert-success" role="alert">
                    Registro Válido
                  </div>
                <div id="fail" style="display: none">
                    <div class="alert alert-danger" role="alert">
                        Error este registro no existe en la base de datos
                    </div>
                </div>
                                
                <div id="expediente" style="display: none"></div>            
                <div id="estado" style="display: none"></div>            
                <div id="nombre" style="display: none"></div>                            
                <div id="fechahora" style="display: none"></div>                            
          </div>


    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>

    function load(){ 
        
        try {

            var parametros = [];
            console.log(' Recuperando parametros ')
            const params = new URLSearchParams(window.location.search)
            params.forEach(function(data,indice,array){            
                var item = {codigo: data, nombre: indice}                
                console.log(item);
                parametros.push(item);                  
            }); 
        
            var uuid = parametros[0].codigo;
            console.log(" UUID: = = = = = = = > > > > > "+uuid);
            var expediente = '';
            
            //var str = JSON.stringify(obj, null, 2); // spacing level = 2
            
            const config = {
                    headers: { 'content-type': 'multipart/form-data' }
            } 
            let formData = new FormData();
            formData.append('uuid', uuid);                     
            axios.post('/certificaciones/consultar',formData,config).then((response) => {                              
                if(response.data.codigo == '200'){                
                    expediente =   response.data.datos[0].expediente;
                    console.log("Expediente " + expediente);  
                    console.log("DATA " + JSON.stringify(response.data, null, 2));  
                    document.getElementById('main').style='block';                
                    document.getElementById('valido').style='block';

                    document.getElementById('expediente').style='block';
                    document.getElementById('expediente').innerHTML="<p><b>Expediente:</b> <br>  "+expediente+"</p>";                                        

                    document.getElementById('estado').style='block';
                    document.getElementById('estado').innerHTML="<p><b>Estado del Expediente:</b> <br>  "+response.data.estado+"</p>";                                        


                    document.getElementById('nombre').style='block';
                    document.getElementById('nombre').innerHTML="<p><b>Nombre: </b> <br> "+response.data.nombre+"</p>";                                        

                    document.getElementById('fechahora').style='block';
                    document.getElementById('fechahora').innerHTML="<p><b>Fecha/Hora de Emisión: </b> <br>"+response.data.datos[0].created_at+"</p>";                                        
                }else{
                    document.getElementById('fail').style='block';                                
                }                   
            }).catch(function (error) {
                document.getElementById('fail').style='block';                                
                
                //console.log(error);
            });
        
        } catch (error) {
            document.getElementById('fail').style='block';                                
            document.getElementById('main').style='none';                                
            document.getElementById('diverror').style='block';                                
            console.error(error);

        }
        

        /* var laravelToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.post('/proccess', {
            name: document.getElementById('form_name').value,
            surname: document.getElementById('form_surname').value,
        })
        .then(function (response) {
            console.log(response.data);
        })
        .catch(function (error) {
            console.log(error);
        });
        */
    };
    window.onload = load;
    </script>
    </body> 