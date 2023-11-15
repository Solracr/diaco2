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
                  <td>{{row.item.registro}}</td>
                  <td>{{row.item.created_at}}</td>                  
                  <td>{{row.item.usuario}}</td>               
                  <td>{{row.item.status}}</td>                                    
                  <td>{{row.item.descripcion}}</td>
                  <td>{{row.item.updated_at}}</td>                   
                  <td>            
                    <!--button @click="fetchData(row.item.qr)" class="btn"><i class="fa fa-file-pdf"></i></button-->
                    <!--v-btn  small color="transparent" @click="fetchData(row.item.expediente)"><i class="fa fa-file-pdf" style="color:red"></i></v-btn-->                                        
                  </td>
                  <td>
                    <div v-if="row.item.status == 'EN PROCESO'">   
                    <v-btn small color="transparent" @click="bitacora(row.item.registro)"><i class="fa fa-list" style="color:black"></i></v-btn>                                                                                                                                                                            
                    </div>
                  </td>
                  
                  <!--td>
                      <v-btn small color="transparent" @click="archivos(row.item.registro)"><i class="fa fa-file-pdf" style="color:blue"></i></v-btn>                                                                                  
                  </td>                  
                  <td>                      
                  </td> 
                  <td>
                      <v-btn small color="transparent" @click="cancelarsolicitud(row.item.registro)"><i class="fa fa-times" style="color:red"></i></v-btn>                                        
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
                  <!--iframe :src="archivoPDF" style="width:90%; height:400px;" frameborder="0"></iframe-->
                  

                  <v-card-text>
                    <v-form ref="form"  lazy-validation>  
                      <div>                        
                          <h4>Observaciones</h4>                        
                        
                        <v-row>
                          <v-col cols="12" md="12"><v-textarea v-model="field.txt_dictamen" background-color="grey lighten-2"
                              color="orange orange-darken-4" label="Escriba sus comentarios:"></v-textarea>
                          </v-col>                                                           
                        </v-row>
                      </div>
                        <v-btn  color="primary" class="mr-4" @click="enviar_dictamen()">Enviar Datos</v-btn>                                 
                    </v-form>
                  </v-card-text>
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
  <div id="xy" style="display: none">
    <img :src="'/img/loading.gif'" />
  </div>
    <div v-if="mModelAnimacion">
      <transition name="model">
        <div class="modal-mask">
           <img
            :src="'/img/loading.gif'"
            style="
              width: 50px;
              height: 50px;
              position: fixed;
              top: 61%;
              left: 54%;
              margin-top: -100px;
              margin-left: -100px;
            "
          />
        </div>
      </transition>
    </div>  




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
      mModelAnimacion:false,      
      field: [],      
      field: {
        txt_dictamen: "",
        registro: "",        
      },
        search: '',
        headers: [          
          { text: 'Registro', value: 'registro' },
          { text: 'Fecha', value: 'created_at' },
          { text: 'Usuario', value: 'usuario' },          
          { text: 'Status', value: 'status' },          
          { text: 'Descripcion', value: 'descripcion' },
          { text: 'Fecha Dictamen', value: 'updated_at' },
        ],
        archivoPDF:'',          
        mModel:false, 
        modalNotificacion:false,
        modalPago:false,
        enviarloading:false,
        enviar1:true, 
        itemx:'',
        exp:'',    
        items: [
          {
            registro:'',
            created_at:'',
            usuario: ' ',
            status: ' ',
            descripcion: ' ', 
            updated_at: ' ',            
          },        
        ],
      }
    },
    created: function() {
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
        enviar_dictamen:function(){
          
          this.field.registro = this.reg;        
         // alert(this.field.registro);
          this.mModelAnimacion = true;                               
          axios
            .post("/ticket/dictamen", this.field)
            .then((res) => {
              console.log("Ejecucion exitosa: ");
              this.$toaster.success("Datos actualizados exitosamente " + res, { timeout: 2500 });
              
              this.mModelAnimacion = false; 
              this.txt_dictamen = '';
              this.mModel = false;           
            })
            .catch((error) => console.log(error));  

          
        },
        bitacora:function(id)   {   
          //actualizar esttaus
          //actualizar la descripcion
          //enviar notificaciones
          this.reg = id;
          this.field.txt_dictamen = "";
          this.mModel = true;      

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
          
          axios.post('/listado_ticket', {action:this.indicador})
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
