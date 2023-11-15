<template>
<v-app id="inspire">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cargar los requisitos</div>
    
                    <div class="card-body">
                       <div id="formatonovalido"  style="display: none;" class="alert alert-warning" role="alert">
                           Solamente se admite PDF
                        </div>
                        <br>
                        <div v-if="validacion" class="alert alert-danger" role="alert">
                        <p class="text-sm-left">Formato PDF es requerido</p>
                        </div>                        
                        <form @submit="formSubmit" enctype="multipart/form-data">
                        
                        <!--strong>Expediente: {{$route.params.id }}</strong-->
                        
                        <strong><b>Fotocopia autenticada de la Representación legal :</b></strong>
                        <input type="file" class="form-control" v-on:change="onFileChange1">    
                        <div id="success1"  style="display: none;" class="alert alert-success" role="alert">
                            Archivo cargado correctamente
                        </div>
                        <div id="success1x"  style="display: none;" class="alert alert-error" role="alert">
                            Error vuelva a intentarlo
                        </div>

                        <strong><b>Fotocopia autenticada pasaporte</b></strong>
                        <input type="file" class="form-control" v-on:change="onFileChange2">    
                        <div id="success2"  style="display: none;" class="alert alert-success" role="alert">
                            Archivo cargado correctamente
                        </div>
                        <div id="success2x"  style="display: none;" class="alert alert-error" role="alert">
                            Error vuelva a intentarlo
                        </div>

                        <strong><b>Fotocopia autenticada situación migratoria</b> </strong>
                        <input type="file" class="form-control" v-on:change="onFileChange3">    
                        <div id="success3"  style="display: none;" class="alert alert-success" role="alert">
                            Archivo cargado correctamente
                        </div>
                        <div id="success3x"  style="display: none;" class="alert alert-error" role="alert">
                            Error vuelva a intentarlo
                        </div>

                        <strong><b>Acta notarial </b></strong>
                        <input type="file" class="form-control" v-on:change="onFileChange4">    
                        <div id="success4"  style="display: none;" class="alert alert-success" role="alert">
                            Archivo cargado correctamente
                        </div>
                        <div id="success4x"  style="display: none;" class="alert alert-error" role="alert">
                            Error vuelva a intentarlo
                        </div>

                        <strong><b>Certificación contable </b></strong>
                        <input type="file" class="form-control" v-on:change="onFileChange5">    
                        <div id="success5"  style="display: none;" class="alert alert-success" role="alert">
                            Archivo cargado correctamente
                        </div>
                        <div id="success5x"  style="display: none;" class="alert alert-error" role="alert">
                            Error vuelva a intentarlo
                        </div>

                        <strong><b>Fotocopia autenticada del nombramiento del extranjero </b></strong>
                        <input type="file" class="form-control" v-on:change="onFileChange6">    
                        <div id="success6"  style="display: none;" class="alert alert-success" role="alert">
                            Archivo cargado correctamente
                        </div>
                        <div id="success6x"  style="display: none;" class="alert alert-error" role="alert">
                            Error vuelva a intentarlo
                        </div>

                        <strong>Declaración jurada </strong>
                        <input type="hidden" v-model="id_solicitud" name="id_solicitud" id="id_solicitud"  />
                        <input type="file" class="form-control" v-on:change="onFileChange7">    
                        <div id="success7"  style="display: none;" class="alert alert-success" role="alert">
                            Archivo cargado correctamente
                        </div>
                        <div id="success7x"  style="display: none;" class="alert alert-error" role="alert">
                            Error vuelva a intentarlo
                        </div>
                        <br><br>
                          <v-btn  color="primary" class="mr-4"  @click="redirect">Finalizar</v-btn>    
                        


                        </form>
                        <br><br>
                          <div v-if="success != ''" class="alert alert-success" role="alert">
                          {{success}}
                        </div>
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

import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";


    export default {
        vuetify: new Vuetify(),    
        mounted() {
            console.log('Component mounted.');
        },
        data() {
            return {    
              params:[],
              id_solicitud:0,          
              mModel: false,
              expediente: '',
              validacion: false,              
              name: '',
              file_1: '',
              file_2: '',
              file_3: '',
              file_4: '',
              file_5: '',
              file_6: '',
              file_7: '',
              success: '',
              success1: '',
              success2: '',
              success3: '',
              success4: '',
              success5: '',
              success6: '',
              success7: '',
              
            };
        },
        created(){
            var parametros = [];
            console.log(' Recuperando parametros ')
            const params = new URLSearchParams(window.location.search)
            params.forEach(function(data,indice,array){            
                var feed = {codigo: data, nombre: indice}                
                parametros.push(feed);                  
            }); 
            this.params = parametros;
            console.log(this.params);
        },
        methods: {
            onFileChange1(e){ 
                  var y = document.getElementById("supermodel");
                            y.style.display = "block";
                //this.mModel = true                
                this.file_1 = e.target.files[0];                
                if (this.file_1.type === 'application/pdf' ) {                    
                    e.preventDefault();
                    let currentObj = this;
    
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    this.id_solicitud = this.params[0].codigo;
                    let formData = new FormData();
                    formData.append('file_1', this.file_1);                       
                    formData.append('id_solicitud', this.id_solicitud);                       
                    
                   axios.post('requisito/upload', formData, config)
                    .then(function (response) {   
                        console.log('Respuesta Axios' + response.data);                        
                        
                        if(response.data == '200'){
                            //alert('Archivo Cargado Exitosamente');
                            
                            var x = document.getElementById("success1");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.success1 = "Archivo cargado correctamente";
                            //this.mModel = false          
                            //this.$toaster.success('Archivo cargado exitosamente',{timeout: 2500})                                               
                        }else{
                            var x = document.getElementById("success1x");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.mModel = false      
                            //this.$toaster.error('Error vuelva a intentarlo',{timeout: 2500})                                              
                        }                                                    
                    });
                    //.catch(function (error) {});
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "none";
                }else{                    
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "block";
                    this.file_1 = '';
                    document.getElementById("formatonovalido").focus();
                    alert('Formato invalido');
                    document.getElementById("supermodel").style.display="none";
                    return; 
                }             
            },
             onFileChange2(e){    
                 document.getElementById("supermodel").style.display="block";                            
                //this.mModel = true                
                this.file_2 = e.target.files[0];                
                if (this.file_2.type === 'application/pdf' ) {                    
                    e.preventDefault();
                    let currentObj = this;
    
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    this.id_solicitud = this.params[0].codigo;
                    let formData = new FormData();
                    formData.append('file_2', this.file_2);                       
                    formData.append('id_solicitud', this.id_solicitud);                       
                    
                   axios.post('requisito/upload', formData, config)
                    .then(function (response) {   
                        console.log('Respuesta Axios' + response.data);                        
                        
                         if(response.data == '200'){
                            //alert('Archivo Cargado Exitosamente');
                            var x = document.getElementById("success2");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.success1 = "Archivo cargado correctamente";
                            //this.mModel = false          
                            //this.$toaster.success('Archivo cargado exitosamente',{timeout: 2500})                                               
                        }else{
                            var x = document.getElementById("success2x");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.mModel = false      
                            //this.$toaster.error('Error vuelva a intentarlo',{timeout: 2500})                                              
                        }                                                     
                    });
                 var x = document.getElementById("formatonovalido");
                    x.style.display = "none";
                }else{                    
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "block";                    
                    this.file_2 = '';
                    document.getElementById("formatonovalido").focus();
                    alert('Formato invalido');
                    document.getElementById("supermodel").style.display="none";
                    return; 
                }          
            },
           onFileChange3(e){     
               document.getElementById("supermodel").style.display="block";                           
                //this.mModel = true    
                            
                this.file_3 = e.target.files[0];                
                if (this.file_3.type === 'application/pdf' ) {                    
                    e.preventDefault();
                    let currentObj = this;
    
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    this.id_solicitud = this.params[0].codigo;
                    let formData = new FormData();
                    formData.append('file_3', this.file_3);                       
                    formData.append('id_solicitud', this.id_solicitud);                       
                    
                   axios.post('requisito/upload', formData, config)
                    .then(function (response) {   
                        console.log('Respuesta Axios' + response.data);                        
                        
                          if(response.data == '200'){
                            //alert('Archivo Cargado Exitosamente');
                            var x = document.getElementById("success3");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.success1 = "Archivo cargado correctamente";
                            //this.mModel = false          
                            //this.$toaster.success('Archivo cargado exitosamente',{timeout: 2500})                                               
                        }else{
                            var x = document.getElementById("success3x");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.mModel = false      
                            //this.$toaster.error('Error vuelva a intentarlo',{timeout: 2500})                                              
                        }                                                        
                    });
                    //.catch(function (error) {});
                  var x = document.getElementById("formatonovalido");
                    x.style.display = "none";
                }else{                    
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "block";                    
                    this.file_3 = '';
                    document.getElementById("formatonovalido").focus();
                    alert('Formato invalido');
                    document.getElementById("supermodel").style.display="none";
                    return; 
                }        
            },
             onFileChange4(e){    
                 document.getElementById("supermodel").style.display="block";                            
                //this.mModel = true                
                this.file_4 = e.target.files[0];                
                if (this.file_4.type === 'application/pdf' ) {                    
                    e.preventDefault();
                    let currentObj = this;
    
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    this.id_solicitud = this.params[0].codigo;
                    let formData = new FormData();
                    formData.append('file_4', this.file_4);                       
                    formData.append('id_solicitud', this.id_solicitud);                       
                    
                   axios.post('requisito/upload', formData, config)
                    .then(function (response) {   
                        console.log('Respuesta Axios' + response.data);                        
                        
                        if(response.data == '200'){
                            //alert('Archivo Cargado Exitosamente');
                            document.getElementById("supermodel").style.display="none";
                            var x = document.getElementById("success4");
                            x.style.display = "block";
                            //this.success1 = "Archivo cargado correctamente";
                            //this.mModel = false          
                            //this.$toaster.success('Archivo cargado exitosamente',{timeout: 2500})                                               
                        }else{
                            var x = document.getElementById("success4x");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.mModel = false      
                            //this.$toaster.error('Error vuelva a intentarlo',{timeout: 2500})                                              
                        }                                                          
                    });
                    //.catch(function (error) {});
                  var x = document.getElementById("formatonovalido");
                    x.style.display = "none";
                }else{                    
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "block";
                    this.file_4 = '';
                    document.getElementById("formatonovalido").focus();
                    alert('Formato invalido');
                    document.getElementById("supermodel").style.display="none";
                    return; 
                }        
            },
             onFileChange5(e){     
                 document.getElementById("supermodel").style.display="block";                           
                //this.mModel = true                
                this.file_5 = e.target.files[0];                
                if (this.file_5.type === 'application/pdf' ) {                    
                    e.preventDefault();
                    let currentObj = this;
    
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    this.id_solicitud = this.params[0].codigo;
                    let formData = new FormData();
                    formData.append('file_5', this.file_5);                       
                    formData.append('id_solicitud', this.id_solicitud);                       
                    
                   axios.post('requisito/upload', formData, config)
                    .then(function (response) {   
                        console.log('Respuesta Axios' + response.data);                        
                        
                          if(response.data == '200'){
                            //alert('Archivo Cargado Exitosamente');
                            var x = document.getElementById("success5");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.success1 = "Archivo cargado correctamente";
                            //this.mModel = false          
                            //this.$toaster.success('Archivo cargado exitosamente',{timeout: 2500})                                               
                        }else{
                            var x = document.getElementById("success5x");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.mModel = false      
                            //this.$toaster.error('Error vuelva a intentarlo',{timeout: 2500})                                              
                        }                                                        
                    });
                    //.catch(function (error) {});
                    this.validacion = false;                    
                 var x = document.getElementById("formatonovalido");
                    x.style.display = "none";
                }else{                    
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "block";
                    this.file_5 = '';
                    document.getElementById("formatonovalido").focus();
                    alert('Formato invalido');
                    document.getElementById("supermodel").style.display="none";
                    return; 
                }         
            },
             onFileChange6(e){  
                 document.getElementById("supermodel").style.display="block";                              
                //this.mModel = true                
                this.file_6 = e.target.files[0];                
                if (this.file_6.type === 'application/pdf' ) {                    
                    e.preventDefault();
                    let currentObj = this;
    
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    this.id_solicitud = this.params[0].codigo;
                    let formData = new FormData();
                    formData.append('file_6', this.file_6);                       
                    formData.append('id_solicitud', this.id_solicitud);                       
                    
                   axios.post('requisito/upload', formData, config)
                    .then(function (response) {   
                        console.log('Respuesta Axios' + response.data);                        
                        
                          if(response.data == '200'){
                            //alert('Archivo Cargado Exitosamente');
                            var x = document.getElementById("success6");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.success1 = "Archivo cargado correctamente";
                            //this.mModel = false          
                            //this.$toaster.success('Archivo cargado exitosamente',{timeout: 2500})                                               
                        }else{
                            var x = document.getElementById("success6x");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.mModel = false      
                            //this.$toaster.error('Error vuelva a intentarlo',{timeout: 2500})                                              
                        }                                                         
                    });
                    //.catch(function (error) {});
                    this.validacion = false;                    
                 var x = document.getElementById("formatonovalido");
                    x.style.display = "none";
                }else{                    
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "block";
                    this.file_6 = '';
                    document.getElementById("formatonovalido").focus();
                    alert('Formato invalido');
                    document.getElementById("supermodel").style.display="none";
                    return; 
                }        
            },
             onFileChange7(e){   
                 document.getElementById("supermodel").style.display="block";                             
                //this.mModel = true                
                this.file_7 = e.target.files[0];                
                if (this.file_7.type === 'application/pdf' ) {                    
                    e.preventDefault();
                    let currentObj = this;
    
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    this.id_solicitud = this.params[0].codigo;
                    let formData = new FormData();
                    formData.append('file_7', this.file_7);                       
                    formData.append('id_solicitud', this.id_solicitud);                       
                    
                   axios.post('requisito/upload', formData, config)
                    .then(function (response) {   
                        console.log('Respuesta Axios' + response.data);                        
                        
                          if(response.data == '200'){
                            //alert('Archivo Cargado Exitosamente');
                            var x = document.getElementById("success7");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.success1 = "Archivo cargado correctamente";
                            //this.mModel = false          
                            //this.$toaster.success('Archivo cargado exitosamente',{timeout: 2500})                                               
                        }else{
                            var x = document.getElementById("success7x");
                            x.style.display = "block";
                            document.getElementById("supermodel").style.display="none";
                            //this.mModel = false      
                            //this.$toaster.error('Error vuelva a intentarlo',{timeout: 2500})                                              
                        }                                                      
                    });
                    //.catch(function (error) {});
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "none";
                    
                }else{                    
                    var x = document.getElementById("formatonovalido");
                    x.style.display = "block";
                    this.file_7 = '';
                    document.getElementById("formatonovalido").focus();
                    alert('Formato invalido');
                    document.getElementById("supermodel").style.display="none";
                    return; 
                }       
            },
            redirect() 
            {
                //this.$router.push('/');
                window.location.href = '/empresa/expedientes';
                
            }
        }
    }
</script>


<style>
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

</style>

