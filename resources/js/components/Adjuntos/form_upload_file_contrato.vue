<template>
  <v-app id="inspire">
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-md-12">
                  <div class="card">
                    <div class="card-header bg-primary" style="color: white; font-size: 24px;"><b>Seleccione los datos del Requisitos (RTU, DPI .. ) que desea adjuntar (Formato PDF)</b></div>


                                  
                      <div class="card-body">
                         <div id="formatonovalido"  style="display: none;" class="alert alert-warning" role="alert">
                             Solamente se admite PDF
                          </div>
  
                          <div id="seleccionar"  style="display: none;" class="alert alert-warning" role="alert">
                             Debe seleccionar una descripción
                          </div>
  
                          <div id="success" style="display: none; opacity: 1;" class="alert alert-success" role="alert">
                              Archivo cargado correctamente                                
                          </div>


  
                          <div id="success1x"  style="display: none;" class="alert alert-warning" role="alert">
                              Este archivo ya existe, desea reemplazarlo?                            
                              <v-btn depressed color="error"  @click="reemplazar()">Si, deseo reemplazarlo</v-btn>
                              <v-btn depressed color="primary"  @click="hidesuccess1x()">No</v-btn>
                          </div>
  
  
                          <br>
                          <div v-if="validacion" class="alert alert-danger" role="alert">
                          <p class="text-sm-left">Formato PDF es requerido</p>
                          </div>                        
                          
                          <!--form @submit="formSubmit" enctype="multipart/form-data"-->                                                                                            
                          <form>
                          <v-select v-model="tipo" :items="items"
                              v-on:change="mostrarDiv"
                              :rules="[(v) => !!v || 'Seleccione un dato']"
                               required filled
                               item-text="descripcion" item-value="id" label="Seleccione la Descripción del archivo que desea cargar:" :return-object="false"  single-line>
                          </v-select>        
                          <div id="divCargar"  style="display: none;" >
                            <label for="fx" style="display: inline-block; padding: 10px 15px; border-radius: 4px; background-color: #007bff; color: white; cursor: pointer; margin-right: 10px;">Haz clic para seleccionar y cargar tu archivo</label>
                            <input id="fx" type="file" class="custom-file-upload" v-on:change="uploadFileAPI" style="border: 2px solid #007bff; padding: 10px; border-radius: 4px; cursor: pointer; color: #007bff; background-color: #f2f2f2;">

                            <!--input id="fx" type="file" class="custom-file-upload" v-on:change="onFileChange" style="border: 2px solid #007bff; padding: 10px; border-radius: 4px; cursor: pointer; color: #007bff; background-color: #f2f2f2;"-->

                          </div>
                          <br><br>
                          <div style="background-color: #FBD603; padding: 20px;"> 
                            <ul id="archivosCargados" style="display: none; font-size: 20px; line-height: 1.5;" class="text-secondary" role="alert">
                                <li><b style='color:red; font-size: 24px;'>Archivos Cargados</b></li>
                                <li v-for="item in items_file" v-bind:key="item.id">
                                    <b style='color:green;'>&#10003; {{ item.mensaje }}</b>
                                </li>
                            </ul>
                        </div>

                          
                          </form>
  
                              <v-btn @click="confirmar()" depressed color="primary">Finalizar</v-btn>
                      </div>
                  </div>
  
  
  
              </div>
          </div>
  
  
  
  
  <div id="xy" style="display: none;">
      <img :src="'/img/loading.gif'" >    
  </div>
  <div id="supermodel" style="display: none;">
      <transition name="model">
       <div class="modal-mask">
        <div class="modal-wrapper">
         <div class="modal-dialog">
          <div class="modal-content">
           <!--div class="modal-header">          
            Conectando..
           </div-->       
           <div class="modal-body">
            <br>
            <img :src="'/img/loading.gif'" style="  width:60px; height:60px; position: fixed; top: 61%;left: 54%; margin-top: -100px; margin-left: -100px;" >                                                                                                         
           </div>
          </div>
         </div>
        </div>
       </div>
      </transition>
     </div>
     <!--DIV CONTAINER FINAL-->
      </div>
  </v-app>
  </template>  
  
  
  <script>
  
  
  
  const lista = [];
  import Vuetify from "vuetify";
  import "vuetify/dist/vuetify.min.css";
      export default {
          vuetify: new Vuetify(),    
          mounted() {
              console.log('Component mounted.');
          },
          data() {
              return {  
                items_file: [] ,                          
                items:[],  
                params:[],
                id_solicitud:0,          
                mModel: false,
                expediente: '',
                validacion: false,                            
                descripcion: '',
                tipo:'',
                file_: '',                            
                success: '',  
                tipo1:'',
                tipo2:'',            
              };
          },
          
          created(){
              var parametros = [];
              console.log('Recuperando parametros')
              const params = new URLSearchParams(window.location.search)
              params.forEach(function(data,indice,array){            
                  var linea = {codigo: data, nombre: indice}                
                  parametros.push(linea);                  
              });
  
              console.log("PARAMETROS - - - - - - >  " + JSON.stringify(parametros, null, 2));  
              this.params = parametros;            
              this.tipo1 = parametros[1].codigo;
              this.tipo2 = parametros[2].codigo;
  
              const config = {
                  headers: { 'content-type': 'multipart/form-data' }
              }        
              let formData = new FormData();        
              formData.append('selector', this.tipo2);        
              formData.append('tipoSolicitud', this.tipo1);                       
                                  
              axios.post('/solicitud/requisitos', formData, config).then((res) =>{           
              console.log(JSON.stringify(res.data));                              
              this.items = res.data;
              })
              .catch((error) => console.log(error))                     
          },
          methods: {
              confirmar() {
                  var txt;
                  if (confirm("Esta seguro que desea finalizar la carga de archivos?")) {
                      this.redirect();
                  } else {
                      txt = "You pressed Cancel!";
                  }
                  //document.getElementById("demo").innerHTML = txt;
              },
              mostrarYOcultarDivFlotante() {
                const divSuccess = document.getElementById('success');

                // Mostrar el div
                divSuccess.style.display = 'block';
                divSuccess.style.opacity = '1';

                // Comienza a desvanecer el div después de 4 segundos
                setTimeout(() => {
                    divSuccess.style.opacity = '0';
                }, 900);

                // Establecer un temporizador para ocultar el div después de 5 segundos
                // Esto se realiza 1 segundo después del inicio de la transición de opacidad para asegurarse de que la animación haya terminado
                setTimeout(() => {
                    divSuccess.style.display = 'none';
                }, 1500);
            },
              mostrarDiv(){
                  var x1 = document.getElementById("divCargar");
                  x1.style.display = "block";                
              },
              hidesuccess1x(){
                  document.getElementById("success1x").style.display = "none"; 
              },             
              onFileChange(e){                 
                  var y = document.getElementById("supermodel");
                  y.style.display = "block";                
                  this.file_ = e.target.files[0];                
                  if (this.file_.type === 'application/pdf' ) {                    
                      e.preventDefault();
                      let currentObj = this;    
                      const config = {
                          headers: { 'content-type': 'multipart/form-data' }
                      }
  
                          if ( this.file_.size > 2 * 1024 * 1024) {
                              e.preventDefault();
                              alert('El archivo que intenta subir es mayor al tamaño maximo permitido  2 MB');
                              document.getElementById("supermodel").style.display="none"; 
                              document.getElementById("fx").value = null;
                              return;
                          }else{
                              this.id_solicitud = this.params[0].codigo;
                              let formData = new FormData();
                              formData.append('file_', this.file_);                       
                              formData.append('id_solicitud', this.id_solicitud);                       
                              formData.append('tipo', this.tipo);                       
                              var temporal = this.tipo;
                              axios.post('/cargar/archivo_contratos', formData, config).then((response) =>{                          
                                  console.log('Respuesta Axios' + response.data);                                                
                                  if(response.data != '300'){
                                      lista.push({mensaje:response.data.descripcion});
  
                                      /*var tokenToRemove;
                                      this.items.forEach(function(id, index) {
                                          console.log('Temporal: ' + temporal + '   ' + ' id: ' + id);
                                          if(temporal === id){
                                              tokenToRemove = index;
                                          }
                                      });
                                      this.items.splice(this.items.indexOf(tokenToRemove), 1);                            */
  
                                      this.tipo = '';
                                      console.log("LISTA - - - - - - >  " + JSON.stringify(lista, null, 2));                              
                                      this.items_file = lista;
                                      this.mostrarYOcultarDivFlotante();
                                      document.getElementById("supermodel").style.display="none";                            
                                      document.getElementById("archivosCargados").style.display="block";                                                        
                                      document.getElementById("fx").value = null;
                                  }else{
                                      document.getElementById("success1x").style.display = "block";                            
                                      document.getElementById("success").style.display="none";                            
                                      document.getElementById("supermodel").style.display="none";                            
                                  }                                                    
                              });
                                  //.catch(function (error) {});
                                  var x = document.getElementById("formatonovalido");
                                  x.style.display = "none";                            
                          }                    
                      }else{                    
                          var x = document.getElementById("formatonovalido");
                          x.style.display = "block";
                          this.file_1 = '';
                          document.getElementById("formatonovalido").focus();
                          alert('Formato invalido');
                          document.getElementById("supermodel").style.display="none";
                          return; 
                      }    
                      
                        var mostrar = document.getElementById("divCargar");
                        mostrar.style.display = "none";       
              },
              uploadFileAPI: async function(e){
                let rutaApi = "/api/cargar/archivo";

                let y = document.getElementById("supermodel");
                y.style.display = "block";

                this.file_ = e.target.files[0];

                if (this.file_.type === 'application/pdf' ) {                    
                    e.preventDefault();

                    if ( this.file_.size > 2 * 1024 * 1024) {
                              e.preventDefault();
                              alert('El archivo que intenta subir es mayor al tamaño maximo permitido  2 MB');
                              document.getElementById("supermodel").style.display="none"; 
                              document.getElementById("fx").value = null;
                              return;
                          }else{
                              this.id_solicitud = this.params[0].codigo;

                              const upload = new FormData();

                              upload.append('file', this.file_);                       
                              upload.append('id_solicitud', this.id_solicitud);                       
                              upload.append('adjunto', this.tipo);
                              // upload.append('selector', 'CA');                       
                              
                              await axios.post(rutaApi, upload).then((response) =>{                          
                                    if(response.data != '300'){
                                      lista.push({mensaje:response.data.descripcion});
                                      this.tipo = '';
                                      console.log("LISTA - - - - - - >  " + JSON.stringify(lista, null, 2));                              
                                      this.items_file = lista;
                                      this.mostrarYOcultarDivFlotante();
                                      document.getElementById("supermodel").style.display="none";                            
                                      document.getElementById("archivosCargados").style.display="block";                                                        
                                      document.getElementById("fx").value = null;
                                  }else{
                                      document.getElementById("success1x").style.display = "block";                            
                                      document.getElementById("success").style.display="none";                            
                                      document.getElementById("supermodel").style.display="none";                            
                                  }                                                    
                              });
                                  var x = document.getElementById("formatonovalido");
                                  x.style.display = "none";                            
                          }
                } else {                    
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "block";
                    this.file_1 = '';
                    document.getElementById("formatonovalido").focus();
                    alert('Formato invalido');
                    document.getElementById("supermodel").style.display="none";
                    return; 
                }
              },                       
              redirect() 
              {
                  var s = '';
                  //this.$router.push('/');
                  if(this.tipo2 === 'D'){
                      window.location.href = '/empresa/expedientes';    
                  }else{
                      if (this.tipo2 === 'G' || this.tipo2 === 'B') s='R';
                      if (this.tipo2 === 'A' || this.tipo2 === 'C') s='C';
                      if (this.tipo2 === 'M') s='M';                    
                      if (this.tipo2 === 'Z') s='Z';                    
                      window.location.href = '/expedientes/grid?selector='+s;    
                  }                                
              }
          }
      }
  </script>
  
  
  <style>
      .custom-file-upload {
          border: 4px solid rgb(255, 60, 0);
          display: inline-block;
          padding: 6px 12px;
          cursor: pointer;
          background: #FFFAAA;
      }
  
      input[type=file]::-webkit-file-upload-button {
      border: 1px solid grey;    
      background: rgb(233, 98, 98);
      }
     .modal-mask {
       position: fixed;
       z-index: 9998;
       top: 0;
       left: 0;
      
       width: 100%;
       height: 100%;
       background-color: rgba(0, 0, 0, .5);
       display: table;
       transition: opacity .3s ease;
     }
  
     .modal-wrapper {
       display: table-cell;
       vertical-align: middle;
     }
  
  
      .fl {float:left;} 
     
      .font-class-name * {
        font-size: 9px;
      }
  
  
  
      .selectB {
      border: 1;
      outline: 1;
      background: #6cb2eb;    
      outline-offset: -2px;
      border-color: whitesmoke;
      outline-color: whitesmoke;        
    }


    .alert.alert-success {
    position: fixed;       /* Hace que el div flote sobre el contenido */
    top: 50%;              /* Centrado verticalmente */
    left: 50%;             /* Centrado horizontalmente */
    transform: translate(-50%, -50%);  /* Centra el div respecto a su ancho y altura */
    z-index: 1000;         /* Garantiza que se muestre por encima de otros contenidos */
    padding: 1em;
    box-shadow: 0 0 10px rgba(0,0,0,0.5); /* Sombra opcional para un efecto más destacado */
    transition: opacity 1s; /* Transición suave de la opacidad en 1 segundo */
    }


  
  </style>
  
  