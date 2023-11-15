
<style scoped>
  table {
    margin-left: auto;
    margin-right: auto;
    padding: 10px;
  }
  td {
    padding: 5px;
  }

  .td-one {
    background-color: rgb(141, 228, 141);
  }

  .td-two{
    background: rgb(235, 235, 134);
  }

  .td-three{
    background-color: rgb(245, 102, 102);
  }
</style>

<template>
<v-app id="inspire">
  <v-form >
    <v-container>
      
         <v-form ref="form"  lazy-validation>     
          <v-card>
          <v-card-title> 
             <!--OBJECT id="ActiveXFirma" classid="clsid:064A99B5-731D-4DCA-8887-FA75D3CE4CC0" codebase="FirmaActiveXSetup.cab"></OBJECT-->
             <input type="hidden" id="hideError" @click="FindAddOnExtension()" value="Esperando">
             <input type="hidden" id="hideDescripcion" value="Esperando">
             <div id="divExtencion"></div>
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
                  <td>{{ new Date(row.item.created_at).toLocaleString() }}</td>
                  <td>{{row.item.tipo2}}</td>
                  <td>{{row.item.expediente}}</td>
                  <td>{{row.item.nombreCompleto}}</td>
                  <td>{{row.item.nacionalidad}}</td>                  
                  <td>{{row.item.status}}</td>               
                  <td :class= estilodias(row.item.fecha_movimiento) >{{row.item.name}}</td>               
                  <td :class= estilodias(row.item.fecha_movimiento) >{{row.item.rol}}</td> 
                  <td>{{Math.ceil(Math.abs(Date.now() - new Date(row.item.fecha_movimiento)) / (1000 * 60 * 60 * 24))}}</td>               
                  <!-- <td><v-btn small color="transparent" @click="fData(row.item.qr)"><i class="fa fa-file" style="color:green"></i></v-btn></td>   
                  <td><v-btn v-if="row.item.status=='APROBACION'" small color="transparent" @click="firma(row.item.expediente)"><i class="fa fa-file" style="color:blue"></i></v-btn></td>
                  <td>
                     <v-btn small color="transparent" @click="operar(row.item.expediente)"><i class="fa fa-tools" style="color:blue"></i></v-btn>   
                     <v-btn small color="transparent" @click="archivos(row.item.expediente)"><i class="fa fa-file-pdf" style="color:red"></i></v-btn>                                                                                                  
                  </td> -->
                </tr>



            </template>
            </v-data-table>
          </v-card>                            
    </v-form>
    </v-container>
  </v-form>



  <!---INICIO MODAL-->
  <div v-if="mModal">
      <transition name="model">
      <div class="modal-mask">
        <div class="modal-wrapper">
        <div class="modal-dialog">
          <div class="modal-content">        
          <div class="modal-body">
          <br>
              <div class="modal-header">             
                    <h4 class="modal-title">Ingrese los datos del análisis juridico</h4>
              </div>
              <div class="modal-body">                       
                  <div class="form-group">                    
                        <!--FORMULARIO-->                        
                         <v-row>                                   
                          <v-col cols="12" md="6">
                                <v-select v-model="evento_id"         
                                  :items="field"
                                  item-text="descripcion"
                                  item-value="id"
                                  label="Tipo de Observacion"          
                                  :return-object="false"                  
                                  single-line
                                ></v-select>    
                          </v-col> 
                          </v-row>               
                          <v-row v-if="mostrarRecibo">               
                          <v-col cols="12" md="6"><v-text-field autocomplete="off" v-model="recibo"  label="Ingrese el recibo" ></v-text-field></v-col>          
                          </v-row>               
                          <v-row>               
                          <v-col cols="12" md="12">
                            <v-textarea v-model="comentario" background-color="grey lighten-2" color="blue blue-darken-4" label="Razonamiento"></v-textarea>
                          </v-col>          
                        </v-row> 
                        <v-row>
                          <v-btn v-if="carga1" loading color="primary" class="mr-4" >Enviar Datos</v-btn>    
                          <v-btn v-if="carga2" color="primary" class="mr-4"  @click="actualizar()">Enviar Datos</v-btn>    
                          <v-btn :disabled="!isValid" color="primary" class="mr-4"  @click="mModal=false">Cancelar</v-btn>     
                        </v-row>                        
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

  
  <!---INICIO MODAL-->
  <div v-if="modelpdf">
      <transition name="model">
      <div class="modal-mask">
        <div class="modal-wrapper">
        <div class="modal-dialog">
          <div class="modal-content">        
          <div class="modal-body">
          <br>             
              <div class="modal-body">
                       <button type="button" class="close" @click="modelpdf=false"><span aria-hidden="true">&times;</span></button>
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

let formatter = new Intl.DateTimeFormat('es-ES', { timeZone: "America/Guatemala" });   
  function getLogDateTime(step){
          var currentdate = new Date(); 
                var datetime_x = "Firmar EndPoint: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " @ "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
                console.log("Step: " + step + ' = = = = = > > > > ' + datetime_x);     
        }
 function FirmarExtension(path_pdf_in, path_pdf_out, razon, ubicacion, imagen, coordenadas, certificado, webserviceURL, SolicitarCertificado){
            getLogDateTime(" Invocando FirmarExtension " + webserviceURL + " -- ");
            var Envio = new Object; 
            Envio.path_pdf_in = path_pdf_in; 
            Envio.path_pdf_out = path_pdf_out; 
            Envio.imagen = imagen; 
            Envio.razon = razon; 
            Envio.ubicacion = ubicacion; 
            Envio.coordenadas = coordenadas; 
            Envio.certificado = certificado; 
            Envio.webservice = webserviceURL;
            Envio.SolicitarCertificado = SolicitarCertificado;
            getLogDateTime(" Creating object Envio " + Envio.SolicitarCertificado + " -- ");
            var evento = document.createEvent('CustomEvent');
            evento.initCustomEvent('addon-message-firmae', true, true, Envio); 
            getLogDateTime(" Ejecutando Evento   xxxx  ");
            document.documentElement.dispatchEvent(evento);
            getLogDateTime("Finalizando ejecucion ");
            //FindAddOnExtension();
        }

/*function  FindAddOnExtension() { 
    var Error = document.getElementById('hideError').value; 
    alert("Mostrar resultado " + Error);
    var Descripcion = document.getElementById('hideDescripcion').value; 
    alert("Descripcion " + Descripcion);
    Respuesta(Error, Descripcion); 
}       
        

function Respuesta(CodigoError, Descripcion) { 
    alert('Codigo de Error: ' + CodigoError + ' : ' + Descripcion); 
}*/

export default {
    vuetify: new Vuetify(),    
    data () {
      return {
        carga1:false,
        carga2:true,
        isValid:true,
        mostrarRecibo:false,
        comentario:'',
        field: [],        
        recibo:'',
        evento_id:0,
        mModal:false,
        search: '',
        expediente:'',
        status:'',
        headers: [         
          { text: 'Fecha Ingreso', value: 'created_at' },
          { text: 'Tipo Documento', value: 'tipo2' },
          { text: 'Expediente', value: 'expediente' },
          { text: 'Nombre', value: 'nombreCompleto' },
          { text: 'Nacionalidad', value: 'nacionalidad' },                
          { text: 'Status', value: 'status' },
          { text: 'Asignado', value: 'name' },                            
          { text: 'Rol', value: 'rol' },                            
          { text: 'Dias sin movimiento', value: '' },
          // { text: 'Acciones', value: '' },  
        ],
        tipo_data: [         
          { text: 'Orden de Pago', value: 'Orden de Pago' },
          { text: 'Notificación Usuario', value: 'Notificacion Usuario' },
          { text: 'Rechazo', value: 'Rechazo' },
          { text: 'Aprobacion de Resolución', value: 'Aprobacion de Resolución' },          
          // { text: 'Acciones', value: '' },  
        ],
        archivoPDF:'',  
        mModal:false,              
        modelpdf:false,
        archivo:"",
        items: [
          {
            created_at:'',
            tipo2:'',
            nombreCompleto:'',
            nacionalidad:'',            
            expediente: '',
            status: '',
            name: '',
            rol: '',
            qr:'',
          },        
        ],
      }
    },
    created: function() {
      var parametros = [];
      // console.log(' Recuperando parametros ')
      // const params = new URLSearchParams(window.location.search)
      // params.forEach(function(data,indice,array){
      //     var linea = {codigo: data, nombre: indice}               
      //     parametros.push(linea);          
      // });
      //console.log("PARAMETROS - - - - - - >  " + JSON.stringify(parametros, null, 2));  
      this.status = "";        
      this.expediente = '';
      this.comentario='';
      this.recibo='';
      this.evento_id=0;
      console.log('montando componente');
      
      this.field = this.tipo_data;
      this.fetchAllData();

      /*axios.post('/eventos/obtenerListado',{
          status: this.status
      })
      .then((res) =>{                                   
        this.field = res.data;
      })
      .catch((error) => console.log(error))
      this.fetchAllData();*/
    },
     methods: { 
        getLogTime(step){
          var currentdate = new Date(); 
                var datetime_x = "Firmar EndPoint: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " @ "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
                console.log("Step: " + step + ' = = = = = > > > > ' + datetime_x);     
        }, 
        FindAddOnExtension() { 
            var Error = document.getElementById('hideError').value; 
            var Descripcion = document.getElementById('hideDescripcion').value; 
            this.Respuesta(Error, Descripcion); 
        },
        Respuesta(CodigoError, Descripcion) { 
            this.$toaster.success('ARCHIVO FIRMADO Exitosamente ' + this.archivo,{timeout: 2500})                              
            this.restaurar(this.archivo);
        },
        fData: function(qr) {                              
            this.modelpdf = true;
            console.log('data :::: ' + qr)
            //this.archivoPDF ='upload/'+qr;
            this.archivoPDF ='/'+qr;            
        },   
        restaurar: function(archivo){
          console.log('========== = = = = Iniciando restauración');                 
          axios.post('/firma/restore', {
            archivo: archivo
            }).then((response) => {             
              console.log(JSON.stringify(response, null, 2));                                                
            if(response.data.code == 200){
                  console.log('========== = = = = Archivo restaurado exitosamente');                 
                  this.$toaster.success('FIRMA ELECTRONICA Exitosa',{timeout: 2500})                              
              }else{
                  this.$toaster.error('Error de comunicación con el servidor de firma',{timeout: 2500})                              
              }
            });
        }, 
        firma: function(expediente) {          
          console.log('Iniciando Firma Electronica :::: Expediente '  + expediente)                     
          axios.post('/firma/firmar', {
            expediente: expediente
          }).then((response) => {    
            console.log(JSON.stringify(response, null, 2));                                                
           if(response.data.code == 200){
                this.archivo = response.data.archivo;
                console.log('Ejecucion exitosa - - - - - - - - - - ' + response.archivo); 
                var currentdate = new Date(); 
                var datetime = "Sync: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " @ "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
                console.log("Iniciando proceso de firma! "+datetime);     
                this.FirmarPdf(response.data.archivo);
                /*setTimeout(() => {                      
                  console.log("Iniciando proceso de firma! "+datetime);                       
                }, 2000);*/                                
                console.log('Fin del proceso!!!!');                 
                this.$toaster.warning('INICIANDO FIRMA ELECTRONICA',{timeout: 2500})                              
                //FEL kali 8112021                
                //window.location.href = "/home";
                //dave
                axios.post('/firma/closeFile', {
                    expediente: expediente
                    }).then((response) => {    
                    console.log(JSON.stringify(response, null, 2));                                                
                }).catch((error) => console.log(error));

            }else{
                this.$toaster.error('Error de comunicación con el servidor de firma',{timeout: 2500})                              
            }
          });
        },            
        archivos: function(expediente){                              
          window.location.href = "/analista/visorexpediente?expediente="+expediente;  
        },
        FirmarPdf(nombre_archivo){
          var path_pdf_in = '\\\\\\\\172.17.10.60\\\\inetpub\\\\wwwroot\\\\FirmaeExtensiones\\\\Pdfs\\\\'+nombre_archivo+'U.pdf';
          var path_pdf_out = '\\\\\\\\172.17.10.60\\\\inetpub\\\\wwwroot\\\\FirmaeExtensiones\\\\Pdfs\\\\'+nombre_archivo+'.pdf';
          /*var path_pdf_in = '../../../../home/disi/Pdfs/'+nombre_archivo+'U.pdf';
          var path_pdf_out = '../../../../home/disi/Pdfs/'+nombre_archivo+'.pdf';*/
          /*var path_pdf_in = '/home/disi/pdfs2/'+nombre_archivo+'U.pdf';
          var path_pdf_out = '/home/disi/pdfs2/'+nombre_archivo+'.pdf';*/
          this.getLogTime(" Iniciando:  " + nombre_archivo);

          /*var path_pdf_in = '/home/disi/firma2/'+nombre_archivo+'U.pdf';
          var path_pdf_out = '/home/disi/firma2/'+nombre_archivo+'.pdf';*/

          this.getLogTime(" Setting variables:  " + path_pdf_in);
          this.getLogTime(" Setting variables:  " + path_pdf_out);

          var imagen = null;
          var razon = 'razon'; 
          var ubicacion = 'ubicacion';
          var coordenadas = "60,200,300,250,1";
          var certificado = '0'; 
          var webserviceURL = 'https://firmae.mintrabajo.gob.gt';
          var SolicitarCertificado = 'true';
          this.getLogTime(" Invocando FirmarExtension ");
          FirmarExtension(path_pdf_in, path_pdf_out, razon, ubicacion, imagen, coordenadas, certificado, webserviceURL, SolicitarCertificado);
        },              
        actualizar(){
          console.log('Inicializando FEL - - - - - - - - - - ');                 
           this.isValid = false;
           this.carga1=true;
           this.carga2=false;
           axios.post('/registro/actualizar', {
              expediente: this.expediente,
              comentario: this.comentario,
              evento_id: this.evento_id,                  
           }).then((response) => {  
            if(response.data.code == '200'){
                console.log('Recuperación exitosa del archivo en el servidor - - - - - - - - - - '); 
                console.log(response.data);                 
                this.$toaster.success('Datos Actualizados Correctamente',{timeout: 2700})                              
                this.mModal = false;
                this.isValid = true; 
                console.log('Iniciando proceso de Firma en servicio local - - - - - - - - - - ');                           
                      const config = {
                          headers: { 'content-type': 'multipart/form-data' }
                      }             
                      //esto es para que quede claro
                      let formData = new FormData();                                           
                      formData.append('expediente', this.expediente);               
                      axios.post('/previo/actualizar', formData, config).then((response) =>{                          
                          console.log('Respuesta Axios' + response.data);                                                
                          if(response.data != '300'){                                              
                              this.modalNotificacion = false;                              
                          }else{
                              this.$toaster.error('Error los datos no fueron cargados correctamente',{timeout: 2500})            
                          }                                                    
                      });
                      window.location.href = "/home";                  
            }else{
                this.$toaster.error('Ha Ocurrido un error, intentelo nuevamente',{timeout: 2500})                              
                this.mModal = false;
            }            
          });
        },
        operar: function(expediente) {                              
          this.expediente = expediente;
          this.mModal = true;
          //window.location.href = "/empresa/webservice?expediente="+expediente;          
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
            //(event.target.tagName)
          }
        },
        estilodias: function (cantidad_dias) {   
          var estilofila="td-one";
          if((Math.ceil(Math.abs(Date.now() - new Date(cantidad_dias)) / (1000 * 60 * 60 * 24)))>4 && (Math.ceil(Math.abs(Date.now() - new Date(cantidad_dias)) / (1000 * 60 * 60 * 24)))<9){
            estilofila = "td-two";
          }
          //if((Math.ceil(Math.abs(Date.now() - new Date(cantidad_dias)) / (1000 * 60 * 60 * 24)))>8){ 
          if((Math.ceil(Math.abs(Date.now() - new Date(cantidad_dias)) / (1000 * 60 * 60 * 24)))>8){
            //daveaxios
            estilofila = "td-three";
            //alert(this.expediente);
             /*axios.post('/firma/rechazar', {
                expediente: this.expediente, status: "Rechazado"
              }).then((response) => {                          
                this.items = response.data;   
                console.log(
                "Resultado - - - - - - >  " +
                  JSON.stringify(this.items, null, 2)
              );                
              });*/
          }
          return(estilofila)
        },
        fetchAllData: function() {          
          //axios.get('listadoSolicitudesEmpresa', {
          axios.post('/listadoAnalistaDashboard', {
            status: this.status, analista: "1"
          }).then((response) => {                          
            this.items = response.data;   
            console.log(
            "Resultado - - - - - - >  " +
              JSON.stringify(this.items, null, 2)
          );
            
          });

         
        

          //axios.get('/user').then(response => {
          //console.log("Usuario Logeado: " + Auth::id());
//})
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
