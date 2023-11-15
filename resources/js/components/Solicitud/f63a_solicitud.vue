<template>
  <v-app id="inspire">
    
    
    <v-container>
    <!-- Use a grid system to align your v-card -->
    <v-row justify="center">
      <v-col cols="12" md="8" lg="6">
        <!-- Card with elevation and padding for better visual appeal -->
        <v-card class="pa-4" elevation="2">
          <!-- Header with a title for your form -->
          <v-card-title class="headline">Formulario de Certificación</v-card-title>
          <v-card-text>
            <v-form v-model="validForm">

              <!-- Nro. Recibo -->
              <v-text-field
                label="Nro. Recibo"
                v-model="form.recibo"
                :rules="[rules.required]"
                required
                outlined
                class="mb-4"
              ></v-text-field>

              <!-- Regional -->
              <v-select
                :items="['Guatemala']"
                label="Regional"
                v-model="form.regional"
                :rules="[rules.required]"
                required
                outlined
                class="mb-4"
              ></v-select>

              <!-- Fecha -->
              <v-menu
                v-model="menu"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="auto"
                class="mb-4"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="form.fecha"
                    label="Fecha"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    :rules="[rules.required]"
                    required
                    outlined
                  ></v-text-field>
                </template>
                <v-date-picker v-model="form.fecha" @input="menu = false"></v-date-picker>
              </v-menu>

              <!-- Consumidor -->
              <v-text-field
                label="Consumidor"
                v-model="form.consumidor"
                :rules="[rules.required]"
                required
                outlined
                class="mb-4"
              ></v-text-field>

              <!-- Lugar -->
              <v-text-field
                label="Lugar"
                v-model="form.lugar"
                :rules="[rules.required]"
                required
                outlined
                class="mb-4"
              ></v-text-field>

              <!-- Rubro -->
              <v-select
                :items="rubros"
                label="Rubro"
                v-model="form.rubro"
                :rules="[rules.required]"
                required
                outlined
                class="mb-4"
              ></v-select>

                 <!-- cantidad -->
                 <v-text-field
                label="Cantidad de cobros"
                v-model="form.deposito"
                :rules="[rules.required]"
                required
                outlined
                class="mb-4"
              ></v-text-field>

                 <!-- Lugar -->
                 <v-text-field
                label="Monto del recibo"
                v-model="form.cantidad"
                :rules="[rules.required]"
                required
                outlined
                class="mb-4"
              ></v-text-field>

              <!-- Submit button with color and size for prominence -->
              <v-btn
                color="primary"
                large
                block
                @click="submitForm"
              >Enviar</v-btn>
              
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>





<div id="xy" style="display: none">
        <img :src="'/img/loading.gif'" />
      </div>
    <!-------Div modal---------->
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
    <!--Div modal-->



    
    <div v-if="waitModel">
      <transition name="model">
        <div class="modal-mask">          
          <br />
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
    <!--DIV CONTAINER FINAL-->

   
  </v-app>
</template>

<script>
//import VueMaterialDateTimePicker from 'vue-material-date-time-picker';
//npm install xlsx
import Vuetify from "vuetify";
//import 'vue-search-select/dist/VueSearchSelect.css'
//import { ModelSelect } from 'vue-search-select'
import "vuetify/dist/vuetify.min.css";
import Multiselect from "vue-multiselect";
import Datepicker from "vuejs-datepicker-module";
import "vuejs-datepicker-module/dist/vuejs-datepicker.css";
var csrf_token = $('meta[name="csrf-token"]').attr("content");
var recarga = 0;


var recargaedit = 0;
var estadoedit = 0;
export default {
  vuetify: new Vuetify(),
  components: {
    Datepicker,
    Multiselect,
  },
  data() {
    return {
      //csrf_token = $('meta[name="csrf-token"]').attr('content'),
      step: 1, // Iniciar en el primer paso
      mModelAnimacion:false,
      mModel:false,
      waitModel: false,
      especial:"",
      modalActive: false,
      modalActivePositivo: false,
      ocultarCui: false,
      Prorroga: false,
      tipoG: false,
      tipoB: false,
      normal: false,
      sociedadAnonima: false,
      casosEspeciales: false,
      refugiados: false,
      refugiados1: false,
      mostrarIdiomas: false,
      activarFechaNacimiento: true,
      valid: true,
      cancelacion: false,
      mModel2: false,
      mModel: false,
      cancelaModel: false,
      idiomasModel: false,
      validarIdiomas: false,
      field: [],
     
      emailRules: [
        (v) =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "Escriba una dirección de E-mail",
      ],
      vacio: [(v) => !!v || "Debe ingresar un dato"],
      numberRule: [
        (v) => Number.isInteger(Number(v)) || "Debe ingresar un valor numerico",
        (v) => v.length == 8 || "El valor debe ser de 8 digitos",
      ],
      numberRuleDpi: [
        (v) => Number.isInteger(Number(v)) || "Debe ingresar un valor numerico",
        (v) => v.length == 13 || "El valor debe ser de 13 digitos",
      ],
      numberRule9: [
        (v) =>
          v.length <= 9 ||
          "El valor debe ser menor o igual 6 digitos y dos decimales",
      ],
      rselect: [(v) => !!v || "Debe hacer clic para seleccionar un dato"],
      
      validForm: true,
      menu: false,
      form: {
        noRecibo: '',
        regional: '',
        fecha: '',
        deposito:'',
        consumidor: '',
        lugar: '',
        rubro: '',
        cantidad:0
      },
      rubros: [
        'Venta de Formularios',
        'Autorizacion y Registro de Libros de Quejas',
        'Reposicion de la Autorizacion del Libro de Quejas',
        'Aprobacion y Registro de Organizacion de Consumidores y Usuarios',
        'Aprobacion y Registro de contratos de Adhesion',
        'Certificaciones',
        'Hojas Adicionales de Certificaciones',
        'Ley de Proteccion al Consumidor y Usuario',
        'Multas por Infracciones a la Ley de Proteccion al Consumidor',
        'Verificacion de la Certificacion de Instrumentos de Medicion',
        'Actualizacion del Libro de Quejas'
      ],
      rules: {
        required: value => !!value || 'El campo es requerido.'
      },
  
    };
  },
  mounted() {
    //
  },
  created() {      
    

    axios
      .get("/empresa/solicitud/nacionalidades")
      .then((res) => {
        this.itemComboNacionalidades = res.data;
      })
      .catch((error) => console.log(error));

    axios
      .get("/empresa/solicitud/departamentos")
      .then((res) => {
        this.itemComboDepartamentos = res.data;
      })
      .catch((error) => console.log(error));
    
      axios
      .get("/solicitud/exp")
      .then((res) => {
        console.log('data de experienciaa ============================= ');        
        var str = JSON.stringify(res.data, null, 2); // spacing level = 2
        console.log('prueba de sql conection');
        console.log(str);
        this.iexperiencia = res.data;
      })
      .catch((error) => console.log(error));

      this.form.recibo = "";
      this.form.regional =  "";        
      this.form.fecha = null;
      this.form.consumidor =  "";
      this.form.lugar = "";
      this.form.rubro = "",
      this.form.cantidad = 0;

      this.mModel = false;
      this.mModelAnimacion = false;
    

    let date = new Date().getFullYear();
    var year = parseInt(date);
    console.log("Año actual: " + year);
    function range(start, end) {
      return Array(end - start + 1)
        .fill()
        .map((_, idx) => start + idx);
    }
    var itemCombo = [];
    var anios = range(1940, year - 18);
    anios.forEach(function (valor, indice, array) {
      var linea = { codigo: valor, nombre: indice };
      itemCombo.push(linea);
    });
    this.itemfecha3 = itemCombo;
    console.log(JSON.stringify(this.itemfecha3));

    var parametros = [];
    console.log(" Recuperando parametros ");
    const params = new URLSearchParams(window.location.search);
    params.forEach(function (data, indice, array) {
      var linea = { codigo: data, nombre: indice };
      parametros.push(linea);
    });
    console.log(
      "PARAMETROS - - - - - - >  " + JSON.stringify(parametros, null, 2)
    );
    this.coex = parametros[0].codigo;
    this.field.tipo1 = parametros[1].codigo;
    this.field.tipo2 = parametros[2].codigo;
    console.log(JSON.stringify(parametros));

    this.field.codigoEmpresa = parametros[0].codigo;
    console.log("Codigo de empresa " + this.field.codigoEmpresa);
    console.log("Tipo 1 Sol/Prorro =========  " + this.field.tipo1);

     if (this.field.tipo2 === "Z") {
       this.cancelacion = true;
     }


    if (this.field.tipo1 === "Prorroga") {
      this.Prorroga = true;
    }
    if (this.field.tipo2 === "A") {
      this.casosEspeciales = true;
      this.tipoParentesco = "Pareja";
      this.normal = true;
      this.tipoG = false;
      this.tipoB = false;
      this.ocultarCui = false;
      this.todos = true;
    }
    if (this.field.tipo2 === "C") {
      this.casosEspeciales = true;
      this.tipoParentesco = "Hijos";
      this.normal = true;
      this.tipoG = false;
      this.tipoB = false;
      this.todos = true;
    }

    if (this.field.tipo2 === "M" || this.field.tipo2 === "D") {
      this.datosLaborales = true;
      this.datosLaboralesParte2 = true;
      this.datosAcademicos = true;
      this.normal = true;
      this.tipoG = false;
      this.tipoB = false;
      this.todos = false;
    }

    if (this.field.tipo2 === "G" || this.field.tipo2 === "B") {
      this.validarIdiomas = true;
      this.refugiados = true;
      this.refugiados1 = true;
      this.todos = true;
    }
    //kalin
    if (this.field.tipo2 === "G") {
      this.tipoG = false;
      this.tipoB = true;
      this.normal = false;
    }
    if (this.field.tipo2 === "B") {
      this.tipoB = false;
      this.tipoG = true;
      this.normal = false;
    }

    if (this.field.tipo2 === "A" || this.tipo2 === "C") {
      this.validarIdiomas = true;
    }

     if (this.field.tipo2 === "Z") {
      this.tipoB = false;
      this.tipoG = false;
      this.normal = false;
      this.datosCancela = true;
      this.refugiados1 = true;
      this.datosLaborales = false;
      this.datosAcademicos = true;
    }

    console.log("Tipo 2 SELECTOR Letra ==========  " + this.field.tipo2);
    console.log("Flag Refugiados ==========  " + this.refugiados);
    console.log("Flag Validar IDIOMAS ==========  " + this.validarIdiomas);
    this.fetchAllData();
  },
  computed: {
    computedDateFormatted() {
      return this.formatDate(this.date);
    },
  },


  methods: {
    submitForm() {      
      this.mModelAnimacion = true;      

        if (this.validForm) {
          // Hacer algo cuando el formulario es válido
          console.log("Formulario enviado:", this.form);
          axios
          .post("/f63a/store", this.form)
          .then((res) => {
            console.log("el ID de la solicitud update es: " + res.data);
            this.$toaster.success("Datos guardados correctamente", { timeout: 500 });
            console.log("DATA OK: " + res.data);
            this.resetForm();
            this.mModelAnimacion = false;   
            this.redirectToCertifications();
          })
          .catch((error) => console.log(error));
        } else {
          console.log("El formulario tiene errores");
        }
        
    },
    redirectToCertifications() {
        const idx = '5465465z';
        const tipo3 = 'z';
        const baseUrl = window.location.origin; // Obtiene el dominio dinámico
        const path = '/certificaciones/grid_f63a_solicitud?Idx=${idx}&tipo3=${tipo3}';
        
        window.location.href = baseUrl + path;
    },
  regresar:function(){
      history.back();
    }, 

    resetForm() {
    this.form = {
      recibo: '',
      regional: '',
      fecha: '',
      deposito: '',
      consumidor: '',
      lugar: '',
      rubro: '',
      deposito: '',
      cantidad: 0 
    };
  },
  cuiIsValid(cui) {
          var console = window.console;
          if (!cui) {
              console.log("CUI vacío");
              return true;
          }

          var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;

          if (!cuiRegExp.test(cui)) {
              console.log("CUI con formato inválido");
              return false;
          }

          cui = cui.replace(/\s/, '');
          var depto = parseInt(cui.substring(9, 11), 10);
          var muni = parseInt(cui.substring(11, 13));
          var numero = cui.substring(0, 8);
          var verificador = parseInt(cui.substring(8, 9));
                    
          var munisPorDepto = [           
          ];
          
          if (depto === 0 || muni === 0)
          {
              console.log("CUI con código de municipio o departamento inválido.");
              return false;
          }
          
          if (depto > munisPorDepto.length)
          {
              console.log("CUI con código de departamento inválido.");
              return false;
          }
          
          if (muni > munisPorDepto[depto -1])
          {
              console.log("CUI con código de municipio inválido.");
              return false;
          }
          
          var total = 0;          
          for (var i = 0; i < numero.length; i++)
          {
              total += numero[i] * (i + 2);
          }          
          var modulo = (total % 11);          
          console.log("CUI con módulo: " + modulo);
          return true;          
    },

    resultadoPositivo() {
      this.modalActivePositivo = false;
    },
    resultadoNegativo() {
      this.modalActive = false;
      window.location.href = "/empresa/solicitud";
    },
    busquedacui() {
      this.$refs.form.validate();
      //this.$toaster.warning('Iniciar consulta de representante',{timeout: 2500})
      this.waitModel = true;
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      let formData = new FormData();
      formData.append("selector", this.selectorSAT);
      formData.append("dato", this.field.numeroDocumento);
      axios
        .post("/ConsultarRepresentante", formData, config)
        .then((response) => {
          console.log(
            "RX Representante ==== - - - - - - >  " +
              JSON.stringify(response, null, 2)
          );
          //this.$toaster.success('Datos recuperados Exitosamente.' + response.data, {timeout: 1500})
          if (response.data.code == "200") {
            console.log(response.data);
            this.field.primerNombre =
              response.data.contribuyente.primerNombreRepresentante;
            this.field.otrosNombres =
              response.data.contribuyente.otrosNombresRepresentante;
            this.field.primerApellido =
              response.data.contribuyente.primerApellidoRepresentante;
            this.field.otrosApellidos =
              response.data.contribuyente.segundoApellidoRepresentante;
            this.field.apellidoCasada =
              response.data.contribuyente.APELLIDO_CASADA;
            this.waitModel = false;
            this.$toaster.success("Datos recuperados Exitosamente.", {
              timeout: 1500,
            });
          } else {
            this.waitModel = false;
            //this.valid = true
            this.$toaster.error("Error de comunicación.", { timeout: 2500 });
          }
        });
    },
   
    onBlurPlaza(){
      this.todos = false;
      const exclusiones = ["GERENTE GENERAL", "JEFE GENERAL", "ADMINISTRADOR", "DIRECTOR"];
      if(exclusiones.includes(this.field.nombrePlaza)){
        this.especial = "1";         
      }
       
    }, 
    clearOthers() {
      this.field.folio = "";
      this.field.partida = "";
      this.field.pesa = "";
    },
    isNumber(e) {
      let char = String.fromCharCode(e.keyCode);
      if (/^[z0-9]+$/.test(char)) return true;
      else e.preventDefault();
    },
    lostFocusDPI() {
      if (this.field.tipodocumento == "DPI") {
        var digitos13 = /^\d{13}$/;
        if (!digitos13.test(this.field.numeroDocumento)) {
          this.$toaster.warning(
            "Campo DPI debe contener 13 digitos, favor corregir",
            { timeout: 4500 }
          );
          return false;
        }
      }
    },
    isNumberEspecial(e) {
      if (this.field.tipodocumento == "DPI") {
        let char = String.fromCharCode(e.keyCode);
        if (/^[z0-9]+$/.test(char)) return true;
        
        else e.preventDefault();
      }
    },
    onlyForCurrency($event) {      
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;      
      if (
        (keyCode < 48 || keyCode > 57) &&
        (keyCode !== 46 || this.price.indexOf(".") != -1)
      ) {        
        $event.preventDefault();
      }      
      if (
        this.price != null &&
        this.price.indexOf(".") > -1 &&
        this.price.split(".")[1].length > 1
      ) {
        $event.preventDefault();
      }
    },
    uppercase_nombre_establecimiento() {
      this.field.nombre_establecimiento = this.field.nombre_establecimiento.toUpperCase();
    },
    uppercase_primerNombre() {
      this.field.primerNombre = this.field.primerNombre.toUpperCase();
    },
    uppercase_otrosNombres() {
      this.field.otrosNombres = this.field.otrosNombres.toUpperCase();
    },
    uppercase_primerApellido() {
      this.field.primerApellido = this.field.primerApellido.toUpperCase();
    },
    uppercase_otrosApellidos() {
      this.field.otrosApellidos = this.field.otrosApellidos.toUpperCase();
    },
    uppercase_apellidoCasada() {
      this.field.apellidoCasada = this.field.apellidoCasada.toUpperCase();
    },
    uppercase_nombrePlaza() {
      this.field.nombrePlaza = this.field.nombrePlaza.toUpperCase();
    },
    openModal1() {
      this.mModel = true;
    },
    openModalc() {
      this.cancelaModel = true;
      
    },
    openModal2() {
      this.mModel2 = true;
    },
    verificarCampos() {},
    seleccionar() {
      /*this.field.fechaNacimiento =
        this.fecha3 + "-" + this.fecha2 + "-" + this.fecha1;
      console.log("Fecha: ===>>>>> " + this.field.fechaNacimiento);*/
      this.mModel = false;
    },
    seleccionarc() {
      this.field.fechaCancelacion =
        this.fechac3 + "-" + this.fechac2 + "-" + this.fechac1;
      console.log("Fecha Cancela: ===>>>>> " + this.field.fechaCancelacion);
      this.valid = true;
      this.cancelaModel = false;
      console.log("Valor de valid " + this.valid);
      
    },
    seleccionar2() {
      this.field.fechaIngreso =
        this.fecha_3 + "-" + this.fecha_2 + "-" + this.fecha_1;
      console.log("Fecha Ingreso al Pais: ===>>>>> " + this.field.fechaIngreso);
      this.mModel2 = false;
    },
    seleccionarIdiomas() {
      this.idiomasModel = false;
    },
    agregarIdioma() {},
    onChangeDepartamento() {
      console.log("El codigo de municipo " + this.pesa.departamento);
      axios
        .put("solicitud/municipios", this.pesa)
        .then((res) => {
          //alert(JSON.stringify(res.data));
          this.itemComboMuncipio = res.data;
        })
        .catch((error) => console.log(error));
    },

    onChangeDepartamento2() {
      console.log("El codigo de municipo " + this.pesa);
      axios
        .put("solicitud/municipios", this.pesa)
        .then((res) => {
          this.itemComboMuncipio2 = res.data;
        })
        .catch((error) => console.log(error));
    },
    
    onChangeNivelEstudio() {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      console.log("El codigo de estudio " + this.field.nivelEstudio);
      let formData = new FormData();
      formData.append("nivelEstudio", this.field.nivelEstudio);
      axios
        .post("/CarreraController/indexObtenerListado", formData, config)
        .then((response) => {
          this.iCarrera = response.data;
          console.log(JSON.stringify(response.data));
        })
        .catch((error) => console.log(error));
    },

    onFileChange(e) {
      this.file_representanteLegal = event.target.files[0];
      console.log(e.target.files[0]);
      this.file = e.target.files[0];
    },
    mostrarInteraccion() {
      this.$toaster.warning("Item seleccionado", { timeout: 2500 });
      console.log("Idiomas: " + this.field.idiomas);
    },
    isDisable() {
      return recarga > 0;
    },
    isDisableedit() {
      return recargaedit > 0;
    },
    isCancelacion(){
      if (this.tipo2=="Z") cancelacion > 0;
    },
    
    isEstadoEdit() {
      //console.log("Visible Edit: " + estadoedit);
      return estadoedit > 0;
    },
    editar() {
      recargaedit = 0;
      this.$forceUpdate();
    },
    fun_cancelacion(){
      
    },      
    fetchAllData: function () {
      
      this.todos = true;
      this.valid = false;
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      let formData = new FormData();
      formData.append("dato", this.field.codigoEmpresa);
      console.log(
        "Codigo de empresa a editar - - - - - - >" + this.field.codigoEmpresa
      );
      var habilitarEdit=0;
      axios
        .post("/registro/obtenerUltimo", this.field)
        .then((res) => {              
          if (res.data[0].evento_id == 8) {
            estadoedit = 1;
          }              
        }).catch((error) => console.log(error));
      axios
        .put("/obtenerSolicitudesEmpresa", {
          nivelEstudio: this.field.codigoEmpresa,
        })
        .then((response) => {

          console.log(
            "Resultado - - - - - - >  " +
              JSON.stringify(response.data, null, 2)
          );                    

          
          //var objFecha = new Date(response.data[0].fechaNacimiento);

          /*var diaNac = objFecha.getDate();
          if (diaNac.toString().length < 2) diaNac = "0" + diaNac;
          this.fecha1 = diaNac;

          var mesNac = objFecha.getMonth("m") + 1;
          if (mesNac.toString().length < 2) mesNac = "0" + mesNac;
          this.fecha2 = mesNac;

          var yearNac = objFecha.getFullYear();
          if (yearNac.toString().length < 2) yearNac = "0" + yearNac;
          console.log("fechaNac: " + response.data[0].estadocivil);
          this.fecha3 = yearNac;*/

          //this.field.fechaNacimiento = yearNac + "-" + mesNac + "-" + diaNac;

          const config = {
            headers: { "content-type": "multipart/form-data" },
          };
          /*console.log("El codigo de estudio " + response.data[0].nivelEstudio);
          let formData = new FormData();
          formData.append("nivelEstudio", response.data[0].nivelEstudio);*/
         
          /*
          axios
            .put("solicitud/municipios", this.field)
            .then((res) => {
              this.itemComboMuncipio = res.data;
              this.field.municipio = response.data[0].municipio;
            })
            .catch((error) => console.log(error));
            */
         
        });

      if (this.field.codigoEmpresa.length > 7) {
        recarga = 1;
        recargaedit = 1;
      }
      if(habilitarEdit==1)
      {
        estadoedit=1;
        
      }
      
    },
  },
};
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;

  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.fl {
  float: left;
}

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

.full-width {
    width: 100%;
}


.headline {
    color: #123456; /* Choose color that fits the theme */
    text-align: center;
    margin-bottom: 20px;
  }
  .v-card {
    margin-top: 20px; /* Space from top */
  }

</style>

