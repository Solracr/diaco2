<template>
<v-app id="inspire">
  <v-form >
    <v-container>
         <v-form ref="form" lazy-validation>     
          <v-card>
          <v-card-title>              
                  <div class='flotar'>
                    <div style='float: left;'>
                        <v-text-field v-model="search" label="Buscar" single-line hide-details></v-text-field>  
                    </div>
                    <div style='float: right;'>   
                        <v-btn color="yellow darken-2" @click="regresar()" >Regresar</v-btn>                                     
                  </div>               
                </div>
            </v-card-title>
            <v-data-table :headers="headers" :items="items" :search="search">
               <template v-slot:item="row">
                <tr>
                  <td>{{row.item.id}}</td>
                  <td>{{row.item.descripcion}}</td>
                  <td>{{row.item.archivo}}</td>                                    
                  <td>{{row.item.expediente}}</td>                  
                  <td>
                    <!-- <v-btn color="primary" @click="fetchData(row.item.archivo)" dark>Visualizar</v-btn> -->
                    <v-btn color="primary" @click="viewDoc(row.item.id, row.item.expediente, row.item.tipo_archivo)" dark>Visualizar</v-btn>                    
                  </td>
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
                  <!-- <iframe :src="archivoPDF" style="width:90%; height:400px;" frameborder="0"></iframe> -->
                  <iframe :src="decodePDF" style="width:90%; height:400px;" frameborder="0"></iframe>
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
        search: '',
        headers: [          
          { text: 'Codigo', value: 'id' },
          { text: 'Descripcion', value: 'descripcion' },
          { text: 'Archivo', value: 'archivo' },        
          { text: 'Expediente', value: 'expediente' },                    
          { text: 'Acción', value: '' },
        ],
        params:[],
        fields: [],  
        archivoPDF:'', 
        getexpediente:'', 
        mModel:false, 
        fields:[
          {
            expediente:''
          },
        ],     
        items: [
          {
            id:'',
            descripcion: ' ',
            archivo: ' ',
            expediente: ' ',            
          },        
        ],
        decodePDF: ''
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
        console.log(this.params);
        this.getexpediente = this.params[0].codigo;
      // this.fetchAllData();
      this.getAllDocuments();
    },
     methods: {           
        fetchData: function(archivo) {                  
            this.mModel = true;
            this.archivoPDF ='/upload/'+archivo;                        
        },
        viewDoc: async function(id_, exp_, ext_) {
          let rutaAPI = "/analista/visualizar/requisitos/";

          let req = new FormData();
          req.append('expediente', exp_);
          req.append('doc', id_);
          req.append('ext', ext_);

          await axios.post(rutaAPI, req, {
            responseType: "blob",
          }).then((response => {
                    const blob = new Blob([response.data]);
                    const oUrl = URL.createObjectURL(blob);
                    // type_ == "pdf" ? [this.doc.pdf = oUrl, this.docName.pdf = `${id_}-${cor_}-${date_}.${type_}`] : null;
                    // type_ == "png" ? [this.doc.img = oUrl, this.docName.img = `${id_}-${cor_}-${date_}.${type_}`] : null;
                    this.mModel = true;
                    this.decodePDF = oUrl;
                })).catch(error => {
                        console.log(error)
                });
        },   
        regresar:function(){
          history.back();
        }, 
        operar: function(data){
          //console.log('operar ' + data);
          alert('En esta sección el analista tendra una ventana de dialogo para el seguimiento de los expedientes');
        },       
        empresa: function(event){                     
          window.location.href = "/empresa/webservice?type="+1;
          //this.$router.push({name:'home', params: {id: '[paramdata]'}});
        },
        redirect: function(id){                     
          //alert('Valor seleccionado ' + id);
          window.location.href = "/empresa/form_solicitud?IdEmpresa="+id;
          //this.$router.push({name:'home', params: {id: '[paramdata]'}});
        },
        greet: function (event) {        
          //alert('Hello ' + this.name + '!')        
          if (event) {
            alert(event.target.tagName)
          }
        },
        fetchAllData: function() {  
           const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    } 
          let formData = new FormData();
          formData.append('expediente', this.getexpediente);                     
          axios.post('/analista/cargarRequisitosExpediente',formData,config).then((response) => {                          
            this.items = response.data;            
            //JSON.stringify(obj, null, 2);
          });
        },
        getAllDocuments: async function(){
          let rutaAPI = "/analista/cargar/requisitos/";                   

          let req = new FormData();
          req.append('expediente', this.getexpediente);

          await axios.post(rutaAPI, req).then((response) => {                          
            this.items = response.data;            
          });
        }
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
