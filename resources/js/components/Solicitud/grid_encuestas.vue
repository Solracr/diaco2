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
                  <td>{{row.item.expediente}}</td>
                  <td>{{row.item.conciliador}}</td>                  
                  <td>{{row.item.usuario}}</td>               
                  <td>{{row.item.fecha}}</td>                                    
                  <td>{{row.item.respuesta1}}</td>                  
                  <td>{{row.item.respuesta2}}</td>                  
                  <td>{{row.item.respuesta3}}</td>                  
                  <td>{{row.item.respuesta4}}</td>                  
                  <td>{{row.item.respuesta5}}</td>                  
                  <td>{{row.item.respuesta6}}</td>                  
                  <td>{{row.item.observaciones}}</td>                  
                  <td>            
                    <!--button @click="fetchData(row.item.qr)" class="btn"><i class="fa fa-file-pdf"></i></button-->
                    <v-btn  small color="transparent" @click="fetchData(row.item.expediente)"><i class="fa fa-file-pdf" style="color:red"></i></v-btn>                                        
                  </td>
                  <!--td>   
                    <v-btn small color="transparent" @click="bitacora(row.item.expediente)"><i class="fa fa-list" style="color:black"></i></v-btn>                                                                                                                                                        
                    
                  </td>
                    <td>
                       <v-btn small color="transparent" @click="archivos(row.item.expediente)"><i class="fa fa-file-pdf" style="color:blue"></i></v-btn>                                                                                  
                    </td>                  
                  <td>

                      <v-btn small color="transparent" @click="versolicitud(row.item.expediente,row.item.tipo2)"><i class="fa fa-file-pdf" style="color:blue"></i></v-btn>                                        
                  </td> 
                  <td>
                      <v-btn small color="transparent" @click="cancelarsolicitud(row.item.expediente)"><i class="fa fa-times" style="color:red"></i></v-btn>                                        
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
                <h4 class="modal-title">Confirmación</h4>
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
          { text: 'Expediente', value: 'expediente' },
          { text: 'Conciliador', value: 'conciliador' },
          { text: 'Usuario', value: 'usuario' },          
          { text: 'Fecha', value: 'fecha' },          
          { text: 'Respuesta1', value: 'respuesta1' },
          { text: 'Respuesta2', value: 'respuesta2' },
          { text: 'Respuesta3', value: 'respuesta3' },
          { text: 'Respuesta4', value: 'respuesta4' },
          { text: 'Respuesta5', value: 'respuesta5' },
          { text: 'Respuesta6', value: 'respuesta6' },          
          { text: 'Observaciones', value: 'observaciones' },
        ],
        archivoPDF:'',  
        mModel:false, 
        modalNotificacion:false,
        modalPago:false,
        enviarloading:false,
        enviar1:true, 
        exp:'',    
        items: [
          {
            id:'',
            expediente:'',
            conciliador: ' ',
            usuario: ' ',
            fecha: ' ',
            total: ' ',
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
               
      //this.indicador = parametros[0].codigo;      
      this.fetchAllData();
    },
     methods: {  
          aceptarNotificacion: function(expediente){
            this.modalNotificacion = true;
            this.exp = expediente;         
          },
         notificar: function(e){  
          
       },
       archivos: function(expediente) {                              
          //  window.location.href = "/analista/visorexpediente?expediente="+expediente;  
        },         
        fetchData: function(qr) {                              
            this.mModel = true;
            //console.log('data :::: ' + qr)
            //this.archivoPDF ='upload/'+qr;
            //this.archivoPDF ='/'+qr;            
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
            //window.location.href = "/empresa/form_solicitud?IdEmpresa="+id+"&tipo1=Solicitud&tipo2="+tipo2;            
        },
        cancelarsolicitud:function(id,tipo2)   {          
            //window.location.href = "/empresa/form_solicitud?IdEmpresa="+id+"&tipo1=Solicitud&tipo2=Z";            
        },
        bitacora:function(id)   {          
            //window.location.href = "/gridBitacora?id="+id;            
        },
        empresa: function(event){                     
            //window.location.href = "/empresa/webservice?type="+1;          
        },
        redirect: function(id){                     
            //alert('Valor seleccionado ' + id);
            //window.location.href = "/empresa/form_solicitud?IdEmpresa="+id;
            //this.$router.push({name:'home', params: {id: '[paramdata]'}});
        },
        greet: function (event) {                  
          /*if (event) {
            alert(event.target.tagName)
          }*/
        },
        fetchAllData: function() {                    
          
          //axios.post('/listado_encuestas', {action:this.indicador})
          axios.post('/listado_encuestas')
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
