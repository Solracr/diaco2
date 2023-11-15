<template>
<v-app id="inspire">
  <v-form >
    <v-container>         
          <v-card v-if="resultado">               
          <v-card-title>                            
          </v-card-title>
            El Ministerio de Economia recibió los datos de la solicitud con el codigo de expediente {{ expediente }}
          </v-card>            
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


</v-app>
</template>
<script>
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";


export default {
    vuetify: new Vuetify(),    
    data () {
      return {
        resultado:false,             
        expediente:'',    
        uuid:'', 
        params:[],                        
        mModel:false,             
      }
    },
    created: function() {
        var parametros = [];
        console.log(' Recuperando parametros ')
        const params = new URLSearchParams(window.location.search)
        params.forEach(function(data,indice,array){            
            var feed = {codigo: data, nombre: indice}                
            parametros.push(feed);                  
        }); 
        this.params = parametros;
        
        this.uuid = this.params[0].codigo;
        console.log(" UUID: = = = = = = = > > > > > "+this.uuid);
        this.fetchAllData();
    },
     methods: {                  
        
        fetchAllData: 
        function() {  
          const config = {
                headers: { 'content-type': 'multipart/form-data' }
          } 
          let formData = new FormData();
          formData.append('uuid', this.uuid);                     
          axios.post('/certificaciones/consultar',formData,config).then((response) => {                              
            if(response.data.codigo == '200'){                
                this.expediente =   response.data.datos[0].expediente;
                console.log("Expediente " + this.expediente);  
                this.$toaster.success('Datos recuperados Exitosamente.', {timeout: 1500})
                this.resultado = true;                
            }else{
                this.resultado = false;                
                //this.mModel=false                                
                this.$toaster.error('Estos datos no son validos',{timeout: 2500})                
            }                   
          });
        },

        //fin de methods
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
