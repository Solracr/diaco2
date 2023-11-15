<template>
<v-app id="inspire">
<v-container>     
<v-card  color="blue-gray lighten-4" >       
<nav class="navbar navbar-dark bg-primary">
<h4>Datos del Extranjero</h4>
</nav>
<v-card-text>
  <v-form ref="form" v-model="valid" lazy-validation >  
      <v-row class="fill-height">
        <v-col cols="12" md="3"><v-text-field autocomplete="off" v-model="field.primerNombre" :rules="vacio" label="Primer Nombre" required></v-text-field></v-col>
        <v-col cols="12" md="3" ><v-text-field autocomplete="off" v-model="field.otrosNombres" label="otros Nombres"></v-text-field></v-col>      
        <v-col cols="12" md="3"><v-text-field autocomplete="off" v-model="field.primerApellido" :rules="vacio" label="Primer Apellido" required></v-text-field></v-col>
        <v-col cols="12" md="3"><v-text-field autocomplete="off" v-model="field.otrosApellidos" label="otros Apellidos"></v-text-field></v-col>
      </v-row>    
      <v-row class="fill-height">       
        <v-col cols="12" md="3"><v-text-field autocomplete="off" v-model="field.apellidoCasada" label="Apelllido Casada"></v-text-field></v-col>      
        <v-col cols="12" md="3"><v-text-field autocomplete="off" v-model="field.numeroTelefono" :rules="numberRule" label="Número de Teléfono" required></v-text-field></v-col>        
        <v-col cols="12" md="3" ><v-select v-model="field.nacionalidad"  :items="itemComboNacionalidades" item-text="GENTILICIO_NAC" 
            item-value="GENTILICIO_NAC" 
            label="Nacionalidad" 
            :return-object="false" 
            :rules="vacio" 
            single-line ></v-select>        
        </v-col>
        <v-col cols="12" md="3"><v-select v-model="field.genero" :items="itemsComboGenero" 
            item-text="genero"
            item-value="genero" 
            label="Genero" 
            :return-object="false" 
            :rules="vacio" 
            single-line></v-select>        
        </v-col>
      </v-row>   
      <v-row>                          
        <v-col cols="12" md="3"><v-text-field autocomplete="off"  @focus="openModal1()" :disabled="!activarFechaNacimiento" v-model="field.fechaNacimiento" :rules="vacio"  label="Fecha Nacimiento" required></v-text-field></v-col>
        <!--VueMaterialDateTimePicker :language="es" v-model="field.fechaNacimiento" :is-date-only="true" /-->                
        <v-col cols="12" md="3" ><v-select v-model="field.estadoCivil" :items="itemsComboCivil" item-text="estadocivil" item-value="estadocivil"
        label="Estado Civil" :return-object="false" :rules="vacio" single-line></v-select>        
        </v-col>
        <v-col cols="12" md="3" ><v-select v-model="field.documentoIdentificacion"  :items="itemsTipoDocumento"
            item-text="tipodocumento"
            item-value="tipodocumento"
            label="Documento Identificación"          
            :return-object="false"
            :rules="vacio"
            single-line></v-select>        
        </v-col>
        <v-col  cols="12" md="3" ><v-text-field autocomplete="off" v-model="field.numeroDocumento" :rules="vacio" label="Número de Documento" required></v-text-field></v-col>                  
      </v-row>     
      <v-row>
      <v-card-text><v-text-field autocomplete="off" v-model="field.direccion" :rules="vacio"  label="Dirección" required hint = 'Ejemplo 1a. calle 2-13 zona 1'></v-text-field></v-card-text>
      </v-row>      
      <v-row>
         <v-col cols="12" md="4" >
            <v-select v-model="field.departamento"         
            :items="itemComboDepartamentos"
            item-text="nombre"
            item-value="codigo"
            label="Departamento"          
            :return-object="false"
            :rules="vacio"
            single-line
            @change="onChangeDepartamento()" ></v-select>        
        </v-col>

         <v-col cols="12" md="4" >
            <v-select
            v-model="field.municipio"         
            :items="itemComboMuncipio"
            item-text="nombre"
            item-value="id"
            label="Municipio"          
            :return-object="false"
            :rules="vacio"
            single-line
          ></v-select>        
        </v-col>
        <v-col cols="12" md="4"> <v-text-field autocomplete="off" v-model="field.correoElectronico" :rules="emailRules" label="Email" required></v-text-field></v-col>      
      </v-row>                                 
<nav class="navbar navbar-dark bg-primary">
<h4>Datos Académicos</h4>
</nav>      
    <v-row>
        <v-col cols="12" md="3"><v-text-field autocomplete="off" v-model="field.profesion" :rules="vacio"  label="Profesión" required></v-text-field></v-col>
        <v-col cols="12" md="3"><v-select v-model="field.nivelEstudio" :items="iniveEstudio" item-text="nivel" item-value="nivel" label="Nivel Estudio" :return-object="false" :rules="vacio" single-line></v-select></v-col>
        <v-col cols="12" md="3"><v-select v-model="field.experiencia" :items="iexperiencia" item-text="experiencia" item-value="vexperiencia" label="Experiencia" :return-object="false" :rules="vacio" single-line></v-select></v-col>     
        <v-col cols="12" md="3"><v-text-field autocomplete="off" v-model="field.ocupacion" :rules="vacio"  label="Ocupación" required></v-text-field></v-col>          
    </v-row>
    <v-row>          
        <v-col cols="12" md="6"><v-text-field autocomplete="off" v-model="field.especificarCarrera" :rules="vacio"  label="Especificar Carrera" required></v-text-field></v-col>
        <v-col cols="12" md="6"><v-text-field autocomplete="off" v-model="field.observaciones" :rules="vacio"  label="Observaciones" required></v-text-field></v-col>     
    </v-row>     
<nav class="navbar navbar-dark bg-primary">
<h4>Datos de la Plaza</h4>
</nav>
        <v-row>
          <v-col cols="12" md="6"><v-text-field autocomplete="off" v-model="field.nombrePlaza" :rules="vacio"  label="Nombre de la plaza" required></v-text-field></v-col>          
          <v-col cols="12" md="3" >
            <v-select v-model="field.periodicidadPago"  :items="itemsComboPeriodicidad" item-text="periodicidad"
            item-value="periodicidad"
            label="Periodicidad de Pago"          
            :return-object="false"
            :rules="vacio"
            single-line>
            </v-select>        
            </v-col>
           <v-col cols="12" md="3"><v-text-field autocomplete="off" v-model="field.montoPago" :rules="vacio"  label="Monto de Pago" required></v-text-field></v-col>          
        </v-row>              
        <v-row>    
            <v-col cols="12" md="3">  
            <v-autocomplete v-model="field.idiomas" :items="itemComboIdiomas"
            @input="mostrarInteraccion()"
            chips
            deletable-chips
            multiple
            color="red"
            :menu-props="{background:'black', align:'center', maxHeight: '400', maxWidth: '50%' }"
            label="Idiomas que requiere el puesto"            
            persistent-hint            
          ></v-autocomplete>                                 
          </v-col>          
          <!--v-col cols="12" md="3"><v-text-field v-if="mostrarIdiomas" v-model="field.idiomas" autocomplete="off"  :rules="vacio"  label="Idiomas" required></v-text-field></v-col-->          
          <v-col cols="12" md="6"><v-subheader ><v-text-field autocomplete="off" v-model="field.funcionesGenerales" :rules="vacio"  label="Funciones Generales" required></v-text-field></v-subheader></v-col>          
        </v-row>

<nav class="navbar navbar-dark bg-primary">
<h4>Situación Migratoria</h4>
</nav>        
          <v-row>
          <v-col cols="12" md="4" >
          <v-select v-model="field.situacionMigratoria" :items="isituacionMigratoria" item-text="mvalue" 
            item-value="mvalue" label="Tipo Situación" :return-object="false" :rules="vacio" single-line v-on="verificarCampos()">
          </v-select>        
          </v-col>
          <v-col cols="12" md="4" v-if="this.field.situacionMigratoria === 'Permanente'"><v-text-field autocomplete="off" v-model="field.expedienteMigracion"   label="Expediente Migracion" ></v-text-field></v-col>
          <v-col cols="12" md="4" v-if="this.field.situacionMigratoria === 'Permanente'"><v-text-field autocomplete="off" v-model="field.llaveMigracion"   label="Llave Migracion" ></v-text-field></v-col>          
        </v-row>          
     <v-btn :disabled="!valid" color="primary" class="mr-4"  @click="agregar">Validar</v-btn>    
    </v-form>    
  </v-card-text>
</v-card>
</v-container>


<!-------Div modal---------->
<div v-if="mModel">
    <transition name="model">
     <div class="modal-mask">
      <div class="modal-wrapper">
       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">          
          Seleccione la fecha de su nacimiento
         </div>       
         <div class="modal-body">
          <br>
          <v-row>
            <v-col cols="12" md="3" ><v-select v-model="fecha1"  :items="itemfecha1" item-text="codigo" 
            item-value="codigo" 
            label="Dia" 
            :return-object="false" 
            :rules="vacio" 
            single-line ></v-select>        
            </v-col>       
            <v-col cols="12" md="3" ><v-select v-model="fecha2"  :items="itemfecha2" item-text="nombre" 
            item-value="codigo" 
            label="Mes" 
            :return-object="false" 
            :rules="vacio" 
            single-line ></v-select>        
            </v-col>  
            <v-col cols="12" md="3" ><v-select v-model="fecha3"  :items="itemfecha3" item-text="codigo" 
            item-value="codigo" 
            label="Año" 
            :return-object="false" 
            :rules="vacio" 
            single-line ></v-select>        
            </v-col>  
            <v-btn color="primary" class="mr-4"  @click="seleccionar()">Seleccionar</v-btn>    
            <v-btn color="primary" class="mr-4"  @click="mModel=false">Cancelar</v-btn>    
          </v-row>

            <!--datepicker :language="es">
              <span slot="afterDateInput" class="animated-placeholder">
              Seleccione su fecha de nacimiento
              </span>
            </datepicker--> 
         </div>
        </div>
       </div>
      </div>
     </div>
    </transition>
   </div>
   <!--Div modal-->



   
<!-------MODAL DE IDIOMAS---------->
<div v-if="idiomasModel">
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
          <v-row>    
            <v-col cols="12" md="4">  <v-autocomplete v-model="field.idiomas" :items="itemComboIdiomas"
            chips
            deletable-chips
            multiple
            :menu-props="{background:'black', align:'center', maxHeight: '400', maxWidth: '50%' }"
            label="Idiomas que requiere el puesto"            
            persistent-hint            
          ></v-autocomplete>        
          </v-col>          
          </v-row>
           
         </div>
        </div>
       </div>
      </div>
     </div>
    </transition>
   </div>
   <!--Div MODAL DE IDIOMAS-->



</v-app>
</template>

<script>
//import VueMaterialDateTimePicker from 'vue-material-date-time-picker';
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";

import Datepicker from 'vuejs-datepicker-module';
import 'vuejs-datepicker-module/dist/vuejs-datepicker.css';


export default {
  vuetify: new Vuetify(),      
  //var csrf_token = $('meta[name="csrf-token"]').attr('content');    
  components: {       
      Datepicker
  },
  /*data: vm => ({
    date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
    dateFormatted: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
    menu1: false,
    menu2: false,
  }),*/     
  data() {              
    return {  
      mostrarIdiomas: false,
      activarFechaNacimiento: true,
      valid: true,            
      mModel:false,
      idiomasModel:false,
      field: [],             
      itemsComboGenero: [
          { genero: 'Hombre' },
          { genero: 'Mujer' }          
      ],
      itemsComboCivil:[
          {estadocivil: 'Casado'},
          {estadocivil: 'Soltero'},
          {estadocivil: 'Unido'},
      ],
      itemsComboPeriodicidad:[
          {periodicidad: 'Quincenal'},
          {periodicidad: 'Mensual'},
          {periodicidad: 'Semanal'},
      ],
      isituacionMigratoria:[
        {mvalue: 'Permanente', tvalue: 'Permanente'},
        {mvalue: 'TemporalEnTramite', tvalue: 'Residencia en Trámite'},
        {mvalue: 'Temporal', tvalue: 'Residencia Temporal'},
        {mvalue: 'PermaenteEnTramite', tvalue: 'Residencia Permanente en Trámite'},
      ],                                    
      iniveEstudio:[
          {nivel: 'Primaria'},
          {nivel: 'Básico'},
          {nivel: 'Diversificado'},
          {nivel: 'Técnico'},
          {nivel: 'Universitario'},
          {nivel: 'Maestria'},
          {nivel: 'Ninguno'},
      ],
      itemfecha1:[ {codigo:'01'},{codigo:'02'},{codigo:'03'},{codigo:'04'},{codigo:'05'},{codigo:'06'},{codigo:'07'},{codigo:'08'},{codigo:'09'},{codigo:'10'},{codigo:'11'},{codigo:'12'},{codigo:'13'},{codigo:'14'},{codigo:'15'},{codigo:'16'},{codigo:'17'},{codigo:'18'},{codigo:'19'},{codigo:'20'},{codigo:'21'},{codigo:'22'},{codigo:'23'},{codigo:'24'},{codigo:'25'},{codigo:'26'},{codigo:'27'},{codigo:'28'},{codigo:'29'},{codigo:'30'},{codigo:'31'} ],
      itemfecha2:[ {nombre:'Enero',codigo:'01'},{nombre:'Febrero',codigo:'02'},{nombre:'Marzo',codigo:'03'},{nombre:'Abril',codigo:'04'},{nombre:'Mayo',codigo:'05'},{nombre:'Junio',codigo:'06'},{nombre:'Julio',codigo:'07'},{nombre:'Agosto',codigo:'08'},{nombre:'Septiembre',codigo:'09'},{nombre:'Octubre',codigo:'10'},{nombre:'Noviembre',codigo:'11'},{nombre:'Diciembre',codigo:'12'} ],
      itemfecha3:[{nombre:'',codigo:''}],
      itemfecha4:[{id:'',codigo:'0', nombre:''}],      
      iexperiencia:[
          {vexperiencia: '1-5', experiencia: '1 a 5 años'},
          {vexperiencia: '6-10', experiencia: '6 a 10 años'},
          {vexperiencia: '10+', experiencia: '10 o más'},
          {vexperiencia: '0', experiencia: 'Sin Experiencia'},          
      ],
      itemsTipoDocumento:[
          {tipodocumento: 'DPI'},
          {tipodocumento: 'Pasaporte'}          
      ],
      itemComboNacionalidades: [],
      itemComboDepartamentos: [],
      itemComboMuncipio: [],
      itemComboIdiomas: [],
      arrayIdiomas:[],
      coex:'',
      emailRules: [ 
        v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Escriba una dirección de E-mail'
      ],
      vacio: [
        v => !!v || 'Debe ingresar un dato',        
      ],   
      numberRule: [v => Number.isInteger(Number(v)) || "Debe ingresar un valor numerico",
      v => v.length == 8 || "El valor debe ser de 8 digitos"], 
      modoEditar: false, 
      fecha1:'',
      fecha2:'',
      fecha3:'', 
      field: {
              //token   : csrf_token,
              primerNombre:'',
              otrosNombres:'',
              primerApellido:'',
              otrosApellidos:'',
              apellidoCasada:'',
              numeroTelefono:'',
              fechaNacimiento:null,
              nacionalidad:'',
              genero:'',
              estadoCivil:'',                  
              documentoIdentificacion:'',
              numeroDocumento:'',
              direccion:'',
              departamento:0,
              municipio:0,
              correoElectronico:'',


              profesion:'',
              nivelEstudio:'',
              especificarCarrera:'',
              experiencia:'',
              ocupacion:'',
              idiomas:'',
              observaciones:'',                  
              
              situacionMigratoria:'',
              expedienteMigracion:'',
              llaveMigracion:'',
              
              nombrePlaza:'',
              perfilPlaza:'',
              funcionesGenerales:'',
              periodicidadPago:'',
              montoPago:0,
              status:'',
              codigoEmpresa:0,
              qr:'',

              tipo1:'Solicitud',
              tipo2:'D',
              expediente:'',
              user_id:'',                
          }     
      }
  },  
  mounted(){
    // 
  },
  created() {      
       axios.get('/empresa/solicitud/nacionalidades').then((res) =>{                                   
          this.itemComboNacionalidades = res.data;
        })
        .catch((error) => console.log(error))

        axios.get('/empresa/solicitud/departamentos').then((res) =>{                          
          this.itemComboDepartamentos = res.data;
        })
        .catch((error) => console.log(error))

        axios.get('/empresa/solicitud/idiomas').then((res) =>{                          
          this.itemComboIdiomas = res.data;                                
        })
        .catch((error) => console.log(error))


        this.field.primerNombre = '';
        this.field.otrosNombres = '';
        this.field.primerApellido = '';
        this.field.otrosApellidos='';
        this.field.apellidoCasada='';
        this.field.numeroTelefono='';
        this.field.fechaNacimiento=null;
        this.field.nacionalidad='';
        this.field.genero='';
        this.field.estadoCivil='';                  
        this.field.documentoIdentificacion='';
        this.field.numeroDocumento='';
        this.field.direccion='';
        this.field.departamento=0;
        this.field.municipio=0;
        this.field.correoElectronico='';


        this.field.profesion='';
        this.field.nivelEstudio='';
        this.field.especificarCarrera='';
        this.field.experiencia='';
        this.field.ocupacion='';
        this.field.idiomas='';
        this.field.observaciones='';
        
        this.field.situacionMigratoria='';
        this.field.expedienteMigracion='';
        this.field.llaveMigracion='';
        
        this.field.nombrePlaza='';
        this.field.perfilPlaza='';
        this.field.funcionesGenerales='';
        this.field.periodicidadPago='';
        this.field.montoPago=0;
        this.field.status='';
        this.field.codigoEmpresa=0;
        this.field.qr='';     
        this.fecha1='';
        this.fecha2='';
        this.fecha3='';  
        
        let date =  new Date().getFullYear();
        var year = parseInt(date);      
        console.log("Año actual: " + year);                     
        function range(start, end) {
          return Array(end - start + 1).fill().map((_, idx) => start + idx)
        }
        var itemCombo = [];
        var anios = range(1920, year-1);       
        anios.forEach( function(valor, indice, array) {
          var feed = {codigo: valor, nombre: indice}
            itemCombo.push(feed);          
        });
        this.itemfecha3 = itemCombo;
        console.log(JSON.stringify(this.itemfecha3));
        
        var parametros = [];
        console.log(' Recuperando parametros ')
        const params = new URLSearchParams(window.location.search)
        params.forEach(function(data,indice,array){
            var feed = {codigo: data, nombre: indice}
            if(indice=='IdEmpresa'){
              //alert('El parametro es: ' + data);
              //this.coex = data;
            }           
            parametros.push(feed);          
        });

        //var obj = JSON.parse(parametros);

      
        //alert(parametros[0].codigo); 
        //alert(parametros[0].nombre);         
        /*for (const param of params) {          
          console.log(param)
        }*/
        this.coex = parametros[0].codigo;
        console.log(JSON.stringify(parametros));
        console.log('Codigo de empresa ' + this.field.codigoEmpresa);
        this.field.codigoEmpresa = parametros[0].codigo;
        console.log('Codigo de empresa ' + this.field.codigoEmpresa);

        /*
        var obj = JSON.parse(json);

      // Define recursive function to print nested values
      function printValues(obj) {
          for(var k in obj) {
              if(obj[k] instanceof Object) {
                  printValues(obj[k]);
              } else {
                  document.write(obj[k] + "<br>");
              };
          }
      };

      */
        
  },
  computed: {   
  computedDateFormatted () {
    return this.formatDate(this.date)
  },
   attributes() {
   /*   return [        
          {
            highlight: {
              backgroundColor: 'black',
              borderColor: 'red',
              borderWidth: '3px',
              borderStyle: 'solid',
              width: '2.4rem',
              height: '2.4rem',
            },
            contentStyle: {
              color: 'grey',
            }                             
        },
      ];*/
    },
  },  
 
  methods:{  
    openModal1(){
      this.mModel = true;
    },
    openModal2(){
      this.idiomasModel = true;
    },
    verificarCampos(){},
    seleccionar(){ 
      this.field.fechaNacimiento = this.fecha3+'-'+this.fecha2+'-'+this.fecha1;
      console.log('Fecha: ===>>>>> ' + this.field.fechaNacimiento);      
      this.mModel = false;
      this.field.fechaNacimiento;
      this.activarFechaNacimiento = false;
    },
    seleccionarIdiomas(){
      //this.field.idiomas = 
      this.idiomasModel = false;
    },
    agregarIdioma(){    
    },
    onChangeDepartamento(){
        console.log("El codigo de municipo " + this.field.departamento)
        axios.put('solicitud/municipios', this.field).then((res) =>{                          
          this.itemComboMuncipio = res.data;
        }).catch((error) => console.log(error))        
    },
    onFileChange(e){
        this.file_representanteLegal = event.target.files[0];
        console.log(e.target.files[0]);
        this.file = e.target.files[0];
    },     
    mostrarInteraccion(){
        this.$toaster.success('Idioma Agregado',{timeout: 2500})    
    },            
    agregar(){     
      if(this.$refs.form.validate()){                
        console.log(this.field.idiomas);
        if(this.field.idiomas.length > 0){         
          if(this.field.idiomas.length<10){
            this.field.idiomas = this.field.idiomas.join();          
          }                     
          axios.post('solicitud/store',this.field).then((res) =>{                
            console.log("el ID de la solicitud es: " + res.data);                    
            this.$toaster.success('Validación correcta',{timeout: 2500})        
            console.log("DATA OK: " + res.data);          
            window.location.href = '/requisitos?id='+res.data;
            //this.$router.push('/Requisitos');            
            //retornar a home
            // this.$router.push('/')
          })
          .catch((error) => console.log(error)            )
        }else{
          this.$toaster.error('Debe ingresar los idiomas',{timeout: 3500})        
        }        
      }else{
        this.$toaster.error('Debe ingresar todos los campos',{timeout: 3500})  
      }      
    },     
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

/*
    #v-select.dropdown.open .dropdown-toggle,
    #v-select.dropdown.open .dropdown-menu {
        border-color: #4CC3D9;
    }

    #v-select .active a {
        background: rgba(50,50,50,.1);
        color: #333;
    }


    #v-select.dropdown .highlight a,
    #v-select.dropdown li:hover a {
        background: #d44926;
        color: rgb(59, 187, 108);        
    }
*/   

</style>

