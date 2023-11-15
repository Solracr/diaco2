<template>
<v-app id="inspire">
  <v-form >
    <v-container>
         <v-form ref="form"  lazy-validation>     
          <v-card>
          <v-card-title>              
              <div class='flotar'>
                <div style='float: left;'>
                    <v-text-field v-model="search" label="Buscar" single-line hide-details></v-text-field>  
                </div>
                <div style='float: right;'>                    
              </div>               
            </div>
            </v-card-title>
            <v-data-table :headers="headers" :items="items" :search="search">
               <template v-slot:item="row">
                <tr>
                  <td>{{row.item.nombreCompleto}}</td>
                  <td>{{row.item.expediente}}</td>
                  <td>{{row.item.correoElectronico}}</td>                                    
                  <td>{{row.item.documentoIdentificacion+'  '+row.item.numeroDocumento}}</td>
                  <td>{{row.item.status}}</td>               
                  <td>            
                    <!--button @click="fetchData(row.item.qr)" class="btn"><i class="fa fa-file-pdf"></i></button-->
                    <v-btn  small color="transparent" @click="fetchData(row.item.qr)"><i class="fa fa-file-pdf" style="color:red"></i></v-btn>                                        
                  </td>
                  <td>   
                     <div v-if="row.item.status == 'ORDEN_PAGO'">
                      <v-btn small color="transparent" @click="cargarpago(row.item.expediente)"><i class="fa fa-credit-card" style="color:#211781; font-size:18px"></i></v-btn>                                        
                       <!--v-btn small color="transparent" @click="actualizarData(row.item.id)"><i class="fa fa-edit" style="color:blue"></i></v-btn>                                        
                      <v-btn small color="transparent" @click="actualizarRequisitos(row.item.id)"><i class="fa fa-file" style="color:green"></i></v-btn-->                                           
                     </div>                      
                  <v-btn small color="transparent" @click="bitacora(row.item.expediente)"><i class="fa fa-list" style="color:rgb(32, 96, 59); font-size:18px"></i></v-btn>                                                                                                                                                                            
                  </td>

                  
                  <td>
                      <v-btn small color="transparent" @click="archivos(row.item.expediente)"><i class="fa fa-file-pdf" style="color:blue"></i></v-btn>                                                                                  
                  </td>                  
                  <!--td>

                      <v-btn small color="transparent" @click="versolicitud(row.item.expediente,row.item.tipo2)"><i class="fa fa-file-pdf" style="color:blue"></i></v-btn>                                        
                  </td> 
                  <td>
                      <v-btn small color="transparent" @click="cancelarsolicitud(row.item.expediente,row.item.tipo2)"><i class="fa fa-times" style="color:red"></i></v-btn>                                        
                  </td-->     
                </tr>
            </template>
            </v-data-table>
          </v-card>        
    </v-form>
    </v-container>
  </v-form>



  <!---INICIO MODAL-->

  <div v-if="mModel">
      <transition name="model">
      <div class="modal-mask">
        <div class="modal-wrapper">
        <div class="modal-dialog">
          <div class="modal-content">        
          <div class="modal-body">
          <br>
              <!--div class="modal-header">             
                <h4 class="modal-title">{{ dynamicTitle }}</h4>
              </div-->
              <div class="modal-body">
                       <button type="button" class="close" @click="mModel=false"><span aria-hidden="true">&times;</span></button>
                  <div class="form-group">                    
                  <iframe :src="archivoPDF" style="width:90%; height:400px;" frameborder="0"></iframe>
                  </div>
              </div>                                           
          </div>
        </div>
      </div>
    </div>
  </div>
 </transition>
</div>


  <!---FIN MODAL-->    

  

  
<!---INICIO MODAL PAGO-->
<div v-if="modalPago">
      <transition name="model">
      <div class="modal-mask">
        <div class="modal-wrapper">
        <div class="modal-dialog">
          <div class="modal-content">        
          <div class="modal-body">
          <br>
              <div class="modal-header">             
                <h4 class="modal-title">Ingrese el Número de Recibo de Pago para activar la opción de Carga de Datos</h4>
              </div>
              <div class="modal-body">
                       <button type="button" class="close" @click="modalPago=false"><span aria-hidden="true">&times;</span></button>
                  <div class="form-group">    
                      <v-row >               
                          <v-col cols="12" md="6"><v-text-field @keypress="uploadBoxFunction()"  v-model="recibo" autocomplete="off"  label="Ingrese el Recibo" ></v-text-field></v-col>          
                          <v-col cols="12" md="6">                     
                            <div v-if="uploadBox">      
                            <input id="fx" type="file"  v-on:change="onFileChange">                                   
                            </div>
                          </v-col>
                      </v-row>                               
                      <!--v-btn v-if="enviar1" color="primary" class="mr-4"  @click="enviar()">Cancelar</v-btn-->    
                      <!--v-btn v-if="enviarloading" loading color="primary" class="mr-4"  >Enviar Datos</v-btn-->    
                  </div>
              </div>                                           
          </div>
        </div>
      </div>
    </div>
  </div>
 </transition>
</div>
<!---FIN MODAL-->    


<!---INICIO MODAL NOTIFICACION-->
  <div v-if="modalNotificacion">
      <transition name="model">
      <div class="modal-mask">
        <div class="modal-wrapper">
        <div class="modal-dialog">
          <div class="modal-content">        
          <div class="modal-body">
          <br>
              <div class="modal-header">             
                <h4 class="modal-title">Confirmación de Notificación</h4>
              </div>
                <div  class="modal-body">
                    <button type="button" class="close" @click="modalNotificacion=false"><span aria-hidden="true">&times;</span></button>
                    <div v-if="showdata" class="form-group">   
                      <v-row >               
                          <v-col cols="12" md="8" ><v-text-field  :rules="vacio"  v-model="nombre" autocomplete="off"  label="Nombre de la persona que recibe la notificación" ></v-text-field></v-col>                                    
                      </v-row> 
                    <v-row>                   
                      <v-col class="d-flex" cols="2" sm="6" >
                        <v-select :items="itemsTipo" label="Tipo documento" outlined></v-select>                        
                      </v-col>
                      <v-col cols="6" md="6"><v-text-field  :rules="vacio"  v-model="numeroDocumento" autocomplete="off"  label="Número de Documento" ></v-text-field></v-col>                                    
                    </v-row>                                                                          
                  </div>
                      <v-btn v-if="enviar1" color="primary" class="mr-4"  @click="notificar()">Aceptar Notificación</v-btn>    
                      <v-btn v-if="enviarloading" loading color="primary" class="mr-4"  >Aceptar Notificación</v-btn>    
              </div>                                           
          </div>
        </div>
      </div>
    </div>
  </div>
 </transition>
</div>
<!---FIN MODAL NOTIFICACION-->    


</v-app>
</template>
<script>
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";


export default {
    props: ['selector'],
    vuetify: new Vuetify(),  
    indicador:'',  
    data () {
      return {
        search: '',
        headers: [          
          { text: 'Nombre', value: 'nombreCompleto' },
          { text: 'Expediente', value: 'expediente' },
          { text: 'Correo', value: 'correoElectronico' },          
          { text: 'Documento', value: 'numeroDocumento' },          
          { text: 'Estatus', value: 'status' },
          { text: 'Certificado', value: '' },
          { text: 'Acciones', value: '' }, 
          { text: 'Adjuntos', value: '' },           
        ],
        archivoPDF:'',          
        mModel:false, 
        files: [],
        uploadBox:false,        
        modalNotificacion:false,
        modalPago:false,
        enviarloading:false,
        enviar1:true, 
        exp:'',
        enviarloading:false,
        enviar1:true,
        recibo:'',
        nombre:'SISTEMA',
        tipoDocumento:'DPI',
        numeroDocumento:'1',        
        search: '',
        file_: '',     
        items: [
          {
            id:'',
            nombreCompleto:'',
            primerNombre: ' ',
            otrosNombres: ' ',
            primerApellido: ' ',
            otrosApellidos: ' ',
            correoElectronico: ' ',
            nombrePlaza: '',
            expediente: '',
            status: '',                                  
            created_at: '',
            qr:'',    
          },        

          
        ],
      }
    },
    created: function() {
      console.log('montando componente');
      var parametros = [];
      console.log('Recuperando parametros')
      const params = new URLSearchParams(window.location.search)
      params.forEach(function(data,indice,array){            
          var linea = {codigo: data, nombre: indice}                
          parametros.push(linea);                  
      });

      console.log("PARAMETROS - - - - - - >  " + JSON.stringify(parametros, null, 2));  
               
      this.indicador = parametros[0].codigo;      
      this.fetchAllData();
    },
     methods: {  
          aceptarNotificacion: function(expediente){
            this.modalNotificacion = true;
            this.exp = expediente;         
          },
          cargarpago: function(id) {                                              
            this.modalPago = true;
            this.exp = id;         
          },
          uploadBoxFunction:function(){
            this.uploadBox = true;
          },  
          onFileChange(e){   
          if(this.recibo != ""){}else{
            alert('Error Debe ingresar primero el recibo, vuelva a intentarlo');            
            return
          }                     
          this.file_ = e.target.files[0]; 
          //this.files = e.target.files[0]; 
          this.enviarloading = true;
          this.enviar1=false;    
          this.tipo = 'Caja';
          let currentObj = this;    
          const config = {
              headers: { 'content-type': 'multipart/form-data' }
          }     
         
            if (this.file_.type === 'image/jpeg' || this.file_.type === 'image/png'  ) {                    
              if ( this.file_.size > 2 * 1024 * 1024) {
                    e.preventDefault();
                    alert('El archivo que intenta subir es mayor al tamaño maximo permitido  2 MB');                            
                    return;
                }else{
                      e.preventDefault();
                      let formData = new FormData();
                      formData.append('file_', this.file_);                              
                      formData.append('tipo', this.tipo);                       
                      formData.append('expediente', this.exp);     
                      var temporal = this.tipo;
                      axios.post('/cargar/uploadPago', formData, config).then((response) =>{                          
                          console.log('Respuesta Axios' + response.data);                                                
                          if(response.data != '300'){
                              this.tipo = '';                                   
                              this.modalPago = false;
                              this.$toaster.success('Datos Cargados Correctamente',{timeout: 2500})                                                                  

                          }else{
                              this.$toaster.error('Error los datos no fueron cargados correctamente',{timeout: 2500})            
                          }                                                    
                      });                  
                }
            }else{
                alert('Error debe cargar un archivo JPG o PNG');                
              return;
            }                                 
       },
         notificar: function(e){  
          const config = {
              headers: { 'content-type': 'multipart/form-data' }
          }             
          let formData = new FormData();
          formData.append('tipoDocumento', '0');                              
          formData.append('numeroDocumento', '0');                       
          formData.append('nombre', 'Sistema');                       
          formData.append('expediente', this.exp);               
          axios.post('/previo/actualizar', formData, config).then((response) =>{                          
              console.log('Respuesta Axios' + response.data);                                                
              if(response.data != '300'){                                              
                  this.modalNotificacion = false;
                  this.$toaster.success('Datos Cargados Correctamente',{timeout: 2500})                                                                  
                  window.location.href = "/home";
              }else{
                  this.$toaster.error('Error los datos no fueron cargados correctamente',{timeout: 2500})            
              }                                                    
          });
       },
       archivos: function(expediente) {                              
            window.location.href = "/analista/visorexpediente?expediente="+expediente;  
        },         
        fetchData: function(qr) {                              
            this.mModel = true;
            console.log('data :::: ' + qr)
            //this.archivoPDF ='upload/'+qr;
            this.archivoPDF ='/'+qr;            
        }, 
        actualizarData: function(id) {                              
            //this.mModel = true;     
            //alert('Aun en construcción');
            //window.location.href = "/empresa/actualizarData?id="+id;            
            //console.log('actualizar DATA = = = = = > > > > '+id);
        },    
        actualizarRequisitos: function(id) {                              
            //alert('Aun en construcción');
            //this.mModel = true;            
            //window.location.href = "/empresa/actualizarRequisitos?id="+id;            
            //console.log('actualizar Requisitos = = = = = > > > >  ID '+id);
        }, 
        versolicitud:function(id,tipo2)   {          
            window.location.href = "/empresa/form_solicitud?IdEmpresa="+id+"&tipo1=Solicitud&tipo2="+tipo2;            
        },
        cancelarsolicitud:function(id,tipo2)   {          
            window.location.href = "/empresa/form_solicitud?IdEmpresa="+id+"&tipo1=Solicitud&tipo2=Z";            
        },
        bitacora:function(id)   {          
            window.location.href = "/gridBitacora?id="+id;            
        },
        empresa: function(event){                     
          window.location.href = "/empresa/webservice?type="+1;          
        },
        redirect: function(id){                     
          //alert('Valor seleccionado ' + id);
          window.location.href = "/empresa/form_solicitud?IdEmpresa="+id;
          //this.$router.push({name:'home', params: {id: '[paramdata]'}});
        },
        greet: function (event) {                  
          if (event) {
            alert(event.target.tagName)
          }
        },
        fetchAllData: function() {                    
          //if pendiente show button
          axios.post('/listado', {action:this.indicador})
          .then((response) =>{                                    
            this.items = response.data;     
            console.log("Respuesta exp: " +  JSON.stringify(response.data,null,2));       
          });
        },
      }
  }
</script>


<style>
  .flotar {
  width:100%;
  display:inline-block;
  /*overflow: auto;*/
  white-space: nowrap;
  margin:5px auto;
  border:1px rgb(255, 255, 255) solid;
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
    .my-custom-class .modal-wrapper {    
        height: 90%;
        position: absolute; 
        top: 5%;
        width: 90%;
        border-radius: 25px;
        display: block;
    }


    .modal-body{
      width: 800px;
    }

    .modal-dialog{
        width: 850px;
    }

    .modal-content{
      width: 850px;
    }

    .pdf-modal-body {
      /* overflow-x: scroll;*/
      overflow-y: scroll;
      height: 400px;
      scroll-behavior: smooth;
    }

  </style>
