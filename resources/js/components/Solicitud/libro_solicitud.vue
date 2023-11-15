<template>
    <v-app id="inspire">
      <v-container>
        
  
  
  
      <div v-if="todos">
        
        <v-card>
          <v-stepper v-model="currentStep" vertical>
            <v-stepper-step :complete="currentStep > 1" step="1">
              Datos Generales
            </v-stepper-step>
  
            <v-stepper-content step="1">
              <!--<v-card-text>-->
                <!-- Fecha de presentación y NIT -->
              <v-form ref="form1" v-model="valid" lazy-validation> 
                <v-row>
                  <v-col cols="12" md="4">
                    <v-text-field :rules="vacio" v-model="libro.fecha_presentacion" label="Fecha de Presentación" type="date" :disabled="isDisableedit()"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="4">
                    <v-text-field :rules="emailRules" v-model="libro.correoelectronico" label="Correo Electrónico" :disabled="isDisableedit()"></v-text-field>
                  </v-col>
                  <!-- Agrega más campos aquí según sea necesario -->
                </v-row>
                <!-- Razón Social y Dirección -->
                <v-row>
                  <!-- Campos para Razón Social y Dirección -->
                </v-row>
                <!-- Otras secciones del formulario -->
              </v-form>
              <v-btn @click="nextStep(2)">Siguiente</v-btn>
              <!--</v-card-text>-->
            </v-stepper-content>
  
            <v-stepper-step :complete="currentStep > 2" step="2">
              Datos de Identificación del Solicitante
          <v-col cols="12" md="6" lg="6">
            <v-text-field v-model="libro.razonsocial" label="Razón Social" :disabled="isDisableedit()"></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
              <v-text-field v-model="libro.nit" label="NIT" :disabled="isDisableedit()"></v-text-field>
          </v-col>
            <v-text-field v-model="libro.direccion" label="Dirección" :disabled="isDisableedit()"></v-text-field>
          </v-col>
          
          <!-- Agrega más campos aquí según sea necesario -->
        </v-row>
  
        <!-- Apartamento y Zona -->
        <v-row>
          <v-col cols="12" md="6" lg="3">
            <v-text-field v-model="libro.apartamento" label="Apartamento" :disabled="isDisableedit()"></v-text-field>
          </v-col>
          <v-col cols="12" md="6" lg="3">
            <v-text-field v-model="libro.zona" label="Zona" :disabled="isDisableedit()"></v-text-field>
          </v-col>
          <v-col cols="12" md="6" lg="3">
            <v-text-field v-model="libro.coloniabarrio" label="Colonia/Barrio" :disabled="isDisableedit()"></v-text-field>
          </v-col>
          <v-col cols="12" md="6" lg="3">
            <v-text-field v-model="libro.municipalidad" label="Municipalidad" :disabled="isDisableedit()"></v-text-field>
          </v-col>
          <!-- Agrega más campos aquí según sea necesario -->
        </v-row>
  
        
        <!-- Departamento y Municipio -->
              <v-row>
                    <v-col cols="12" md="6" lg="3">
                      <v-select v-model="libro.departamento" :items="itemComboDepartamentos" item-text="nombre" item-value="id" label="Departamento" :disabled="isDisableedit()" single-line @change="onChangeDepartamento()"></v-select>
                    </v-col>        
                    <v-col cols="12" md="6" lg="3">
                      <v-select v-model="libro.municipio" :items="itemComboMuncipio" item-text="nombre" item-value="id" label="Municipio" :disabled="isDisableedit()" single-line></v-select>
                    </v-col>
                    <v-col cols="12" md="6" lg="3">
                      <v-text-field v-model="libro.telefono" label="Teléfono" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6" lg="3">
                      <v-text-field v-model="libro.fax" label="Fax" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                    <!-- Agrega más campos aquí según sea necesario -->
                </v-row>      
                <v-btn @click="step--">Atrás</v-btn>
                <v-btn @click="step++">Siguiente</v-btn>
              </v-card-text>
  =======
            <!--<v-card-text>-->
            <v-form ref="form2" v-model="valid" lazy-validation> 
                 <!-- Razón Social y Dirección -->
              <v-row>
                <v-col cols="12" md="6" lg="6">
                  <v-text-field :rules="vacio" v-model="libro.razonsocial" label="Razón Social" :disabled="isDisableedit()"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field :rules="vacio" v-model="libro.nit" label="NIT" :disabled="isDisableedit()"></v-text-field>
                </v-col>
                <v-col cols="12" md="6" lg="6">
                  <v-text-field :rules="vacio" v-model="libro.direccion" label="Dirección" :disabled="isDisableedit()"></v-text-field>
                </v-col>
          <!-- Agrega más campos aquí según sea necesario -->
              </v-row>
        <!-- Apartamento y Zona -->
              <v-row>
                <v-col cols="12" md="6" lg="3">
                  <v-text-field :rules="vacio" v-model="libro.apartamento" label="Apartamento" :disabled="isDisableedit()"></v-text-field>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                  <v-text-field :rules="vacio" v-model="libro.zona" label="Zona" :disabled="isDisableedit()"></v-text-field>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                  <v-text-field :rules="vacio" v-model="libro.coloniabarrio" label="Colonia/Barrio" :disabled="isDisableedit()"></v-text-field>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                  <v-text-field :rules="vacio" v-model="libro.municipalidad" label="Municipalidad" :disabled="isDisableedit()"></v-text-field>
                </v-col>
          <!-- Agrega más campos aquí según sea necesario -->
              </v-row>
        <!-- Departamento y Municipio -->
              <v-row>
                <v-col cols="12" md="6" lg="3">
                  <v-select :rules="vacio" v-model="libro.departamento" :items="itemComboDepartamentos" item-text="nombre" item-value="id" label="Departamento" :disabled="isDisableedit()" single-line @change="onChangeDepartamento()"></v-select>
                </v-col>        
                <v-col cols="12" md="6" lg="3">
                  <v-select :rules="vacio" v-model="libro.municipio" :items="itemComboMuncipio" item-text="nombre" item-value="id" label="Municipio" :disabled="isDisableedit()" single-line></v-select>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                  <v-text-field :rules="vacio" v-model="libro.telefono" label="Teléfono" :disabled="isDisableedit()"></v-text-field>
                </v-col>
                <v-col cols="12" md="6" lg="3">
                  <v-text-field :rules="vacio" v-model="libro.fax" label="Fax" :disabled="isDisableedit()"></v-text-field>
                </v-col>
                    <!-- Agrega más campos aquí según sea necesario -->
              </v-row>
            </v-form>        
            <v-btn @click="prevStep(step)">Atrás</v-btn>
            <v-btn @click="nextStep(3)">Siguiente</v-btn>
              <!--</v-card-text>-->
  >>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
            </v-stepper-content>
  
            <!-- Agregar más pasos y contenido según sea necesario -->
  
            <v-stepper-step step="3">
              Datos del Establecimiento
            </v-stepper-step>
  
            <v-stepper-content step="3">
              <!--<v-card-text>-->
                <v-form ref="form3" v-model="valid" lazy-validation>
                    <!-- Resumen de los datos ingresados -->
                  <v-row>       
                    <v-col cols="12" md="6" >
                      <v-text-field :rules="vacio" v-model="libro.f63a" label="No. Recibo" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6" >
                      <v-text-field :rules="vacio" v-model="libro.nombreestablecimiento" label="Nombre del Establecimiento" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                      <v-text-field :rules="vacio" v-model="libro.representantelegal" label="Representante Legal" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                        <!-- Agrega más campos aquí según sea necesario -->
                  </v-row>
                    <!-- Dirección 2 y Número de Casa -->
                  <v-row>
                    <v-col cols="12" md="3" >
                      <v-text-field :rules="vacio" v-model="libro.direccion2" label="Dirección del Establecimiento" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3" >
                      <v-text-field :rules="vacio" v-model="libro.numero_casa" label="Número de Casa" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                      <v-text-field :rules="vacio" v-model="libro.zona_2" label="Zona" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                      <v-text-field :rules="vacio" v-model="libro.coloniabarrio2" label="Colonia/Barrio" :disabled="isDisableedit()"></v-text-field>
                    </v-col>
                      <!-- Agrega más campos aquí según sea necesario -->
                  </v-row>                        
                  <v-row>            
                    <v-col cols="12" md="6" lg="3">
                      <v-select :rules="vacio" v-model="libro.departamento2" :items="itemComboDepartamentos" item-text="nombre" item-value="id" label="Departamento del Establecimiento" :disabled="isDisableedit()" single-line @change="onChangeDepartamento2()"></v-select>
                    </v-col>
                    <v-col cols="12" md="6" lg="3">
                      <v-select :rules="vacio" v-model="libro.municipio2" :items="itemComboMuncipio" item-text="nombre" item-value="id"  label="Municipio del Establecimiento" :disabled="isDisableedit()"></v-select>
                    </v-col>              
                      <!-- Agrega más campos aquí según sea necesario -->
                    <v-col cols="12" md="6" lg="3">
                      <!--<v-text-field v-model="libro.tipoestablecimiento" label="Tipo de Establecimiento" :disabled="isDisableedit()"></v-text-field>-->
                      <v-select :rules="vacio" v-model="libro.tipoestablecimiento" :items="itemsComboEstable" item-text="nombre" item-value="id"  label="Tipo de Establecimiento" :disabled="isDisableedit()"></v-select>
                    </v-col>
                  </v-row>                          
  
                  <v-row>
                    <v-col cols="12" md="6">
                      <v-select :rules="vacio" v-model="libro.sededepartamental" :items="itemComboSedes" item-text="nombre" item-value="id"  label="Sede Departamental de DIACO mas cercana para entregarle su Libro" :disabled="isDisableedit()"></v-select>
                    </v-col>  
                    <v-col cols="12" md="6">
                      <v-textarea :rules="vacio" v-model="libro.detalle" label="Observaciones" :disabled="isDisableedit()"></v-textarea>
                    </v-col>
<<<<<<< HEAD
=======
                    <!-- Agrega más campos aquí según sea necesario -->
                  </v-row>            
              <v-btn @click="step--">Atrás</v-btn>
              <v-btn @click="submitForm">Enviar</v-btn>
            </v-card-text>
=======
            <!--<v-card-text>-->
              <v-form ref="form3" v-model="valid" lazy-validation>
                  <!-- Resumen de los datos ingresados -->
                <v-row>       
                  <v-col cols="12" md="6" >
                    <v-text-field :rules="vacio" v-model="libro.f63a" label="No. Recibo" :disabled="isDisableedit()"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field :rules="vacio" v-model="libro.patente" label="No. Patente" :disabled="isDisableedit()"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6" >
                    <v-text-field :rules="vacio" v-model="libro.nombreestablecimiento" label="Nombre del Establecimiento" :disabled="isDisableedit()"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field :rules="vacio" v-model="libro.representantelegal" label="Representante Legal" :disabled="isDisableedit()"></v-text-field>
                  </v-col>
>>>>>>> b47e6fb78126ea2e45e375d9f97356f07c9f2458
                      <!-- Agrega más campos aquí según sea necesario -->
                  </v-row>            
                </v-form>
                <v-btn @click="prevStep(step)">Atrás</v-btn>
                <v-btn @click="submitForm">Enviar</v-btn>
              <!--</v-card-text>-->
            </v-stepper-content>
          </v-stepper>
        </v-card>
  
      </div><!--DIV PARA CONTROLAR LO QUE SE MUESTRA si la bolsa no tiene respuesta-->
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
  
  
  
      
<<<<<<< HEAD
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
  
      <!-------Div modal INGRESO AL PAIS---------->
      <div v-if="mModel2">
        <transition name="model">
          <div class="modal-mask">
            <div class="modal-wrapper">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    Seleccione fecha de Ingreso a Guatemala
                  </div>
                  <div class="modal-body">
                    <br />
                    <v-row>
                      <v-col cols="12" md="3"
                        ><v-select
                          v-model="fecha_1"
                          :items="itemfecha1"
                          item-text="codigo"
                          item-value="codigo"
                          label="Día"
                          :return-object="false"
                          :rules="vacio"
                          single-line
                        ></v-select
                      ></v-col>
                      <v-col cols="12" md="3"
                        ><v-select
                          v-model="fecha_2"
                          :items="itemfecha2"
                          item-text="nombre"
                          item-value="codigo"
                          label="Mes"
                          :return-object="false"
                          :rules="vacio"
                          single-line
                        ></v-select
                      ></v-col>
                      <v-col cols="12" md="3"
                        ><v-select
                          v-model="fecha_3"
                          :items="itemfecha3"
                          item-text="codigo"
                          item-value="codigo"
                          label="Año"
                          :return-object="false"
                          :rules="vacio"
                          single-line
                        ></v-select
                      ></v-col>
                      <v-btn color="primary" class="mr-4" @click="seleccionar2()"
                        >Seleccionar</v-btn
                      >
                      <v-btn color="primary" class="mr-4" @click="mModel2 = false"
                        >Cancelar</v-btn
                      >
                    </v-row>                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
      <!--Div modal-->
  
      <!-------MODAL DE IDIOMAS---------->
      <div v-if="modalActive">
        <transition name="model">
          <div class="modal-mask">
            <div class="modal-wrapper">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">Advertencia!</div>
                  <div class="modal-body">
                    <br />
                    <h3>
                      Existen registros de esta busqueda en nuestra Bolsa de
                      Empleo, la solicitud no puede continuar.
                    </h3>
                    <v-row>
                      <v-col cols="12" md="4">
                        <v-btn
                          color="primary"
                          class="mr-4"
                          @click="resultadoNegativo()"
                          >Aceptar</v-btn
                        >
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
  
      <!-------MODAL DE IDIOMAS---------->
      <div v-if="modalActivePositivo">
        <transition name="model">
          <div class="modal-mask">
            <div class="modal-wrapper">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">Bolsa de Empleo</div>
                  <div class="modal-body">
                    <br />
                    <h3>
                      La Solicitud puede continuar, no existen coincidencias en la
                      base de datos.
                    </h3>
                    <v-row>
                      <v-col cols="12" md="4">
                        <v-btn
                          color="primary"
                          class="mr-4"
                          @click="resultadoPositivo()"
                          >Aceptar</v-btn
                        >
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
                    <br />
                    <v-row>
                      <v-col cols="12" md="4"> </v-col>
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
=======
      modoEditar: false,
      fecha1: "",
      fecha2: "",
      fecha3: "",
      fecha_1: "",
      fecha_2: "",
      fecha_3: "",
      datosLaborales: false,
      datosLaboralesParte2: false,
      todos:false,
      datosAcademicos: false,
      datosCancela: false,
      requisitos_vector: [],

      itemsCombo: [
        { textos: "Gubernamental", valores: "1" },
        { textos: "Privada", valores: "2" },
        { textos: "Organización no gubernamental", valores: "3" },
        { textos: "Organismo internacional", valores: "4" },
        { textos: "Otros", valores: "5" },

      ],

      libro: {
        token: csrf_token,
        fecha_presentacion: "",
        nit: "",
        patente: "",
        razonsocial: "",
        direccion: "",
        apartamento: "",
        zona: "",
        coloniabarrio: "",
        municipalidad: "",
        departamento: null,
        municipio: null,
        telefono: "",
        fax: "",
        correoelectronico: "",
        nombreestablecimiento: "",
        direccion2: "",
        numero_casa: "",
        zona_2: "",
<<<<<<< HEAD
        coloniabarrio_2: "",
=======
        coloniabarrio2: "",
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
        municipio2: null,
        departamento2: null,
        sededepartamental: "",
        tipoestablecimiento: "",
        detalle: "",
        f63a: "",
        representantelegal: "",
<<<<<<< HEAD
        user_id: "",
=======
        user_id: 0,
        f63a: ""
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
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
<<<<<<< HEAD
=======

    axios
      .get("/libro/colocar/sede")
      .then((res) => {
        this.itemComboSedes = res.data;
      })
      .catch((error) => console.log(error));

    axios
      .get("/libro/colocar/tipo_establecimiento")
      .then((res) => {
        this.itemsComboEstable = res.data;
      })
      .catch((error) => console.log(error));
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
    
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
    
      this.libro.fecha_presentacion = "";
      this.libro.nit = "";
      this.libro.razonsocial = "";
      this.libro.direccion = "";      
      this.libro.apartamento = "";
      this.libro.zona = "";
      this.libro.coloniabarrio = "";
      this.libro.municipalidad = "";
      this.libro.departamento = null;
      this.libro.municipio = null;
      this.libro.telefono = "";
      this.libro.fax = "";
      this.libro.correoelectronico = "";
      this.libro.nombreestablecimiento = "";
      this.libro.direccion2 = "";
      this.libro.numero_casa = "";
      this.libro.zona_2 = "";
<<<<<<< HEAD
      this.libro.coloniabarrio_2 = "";
=======
      this.libro.coloniabarrio2 = "";
>>>>>>> a6d14650e684b4ee169f5fc59ad3ee668d95ec5f
      this.libro.municipio2 = null;
      this.libro.departamento2 = null;
      this.libro.sededepartamental = "";
      this.libro.tipoestablecimiento = "";
      this.libro.detalle = "";
      this.libro.f63a = "";
      this.libro.representantelegal = "";


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
>>>>>>> b47e6fb78126ea2e45e375d9f97356f07c9f2458
    },
    data() {
      return {
        //csrf_token = $('meta[name="csrf-token"]').attr('content'),
        step: 1, // Iniciar en el primer paso
        currentStep: 1,
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
        itemsComboGenero: [{ genero: "Masculino" }, { genero: "Femenino" }],
        itemsComboCivil: [
          { estadocivil: "Casado" },
          { estadocivil: "Soltero" },
          { estadocivil: "Unido" },
        ],
        itemsComboPeriodicidad: [
          { periodicidad: "Quincenal" },
          { periodicidad: "Mensual" },
          { periodicidad: "Semanal" },
        ],
        isituacionMigratoria: [
          { mvalue: "Permanente", tvalue: "Permanente" },
          { mvalue: "TemporalEnTramite", tvalue: "Residencia en Trámite" },
          { mvalue: "Temporal", tvalue: "Residencia Temporal" },
          {
            mvalue: "PermanenteEnTramite",
            tvalue: "Residencia Permanente en Trámite",
          },
        ],
        iniveEstudio: [],
        iOcupacion: [],
        iCarrera: [],
        itemfecha1: [
          { codigo: "01" },
          { codigo: "02" },
          { codigo: "03" },
          { codigo: "04" },
          { codigo: "05" },
          { codigo: "06" },
          { codigo: "07" },
          { codigo: "08" },
          { codigo: "09" },
          { codigo: "10" },
          { codigo: "11" },
          { codigo: "12" },
          { codigo: "13" },
          { codigo: "14" },
          { codigo: "15" },
          { codigo: "16" },
          { codigo: "17" },
          { codigo: "18" },
          { codigo: "19" },
          { codigo: "20" },
          { codigo: "21" },
          { codigo: "22" },
          { codigo: "23" },
          { codigo: "24" },
          { codigo: "25" },
          { codigo: "26" },
          { codigo: "27" },
          { codigo: "28" },
          { codigo: "29" },
          { codigo: "30" },
          { codigo: "31" },
        ],
        itemfecha2: [
          { nombre: "Enero", codigo: "01" },
          { nombre: "Febrero", codigo: "02" },
          { nombre: "Marzo", codigo: "03" },
          { nombre: "Abril", codigo: "04" },
          { nombre: "Mayo", codigo: "05" },
          { nombre: "Junio", codigo: "06" },
          { nombre: "Julio", codigo: "07" },
          { nombre: "Agosto", codigo: "08" },
          { nombre: "Septiembre", codigo: "09" },
          { nombre: "Octubre", codigo: "10" },
          { nombre: "Noviembre", codigo: "11" },
          { nombre: "Diciembre", codigo: "12" },
        ],
        itemfecha3: [{ nombre: "", codigo: "" }],
        itemfecha4: [{ id: "", codigo: "0", nombre: "" }],
        iexperiencia: [],
  
        itemsTipoDocumento: [
          { tipodocumento: "DPI" },
          //{ tipodocumento: "Pasaporte" },
        ],
  
        tipoGItem: [{ tipodocumento: "Constancia" }],
        itemsTipoEstablecimiento: [{tipoestablecimiento: "Establecimiento Educativo"},{ tipoestablecimiento:"Establecimiento Comercial Individual"},{ tipoestablecimiento:"Establecimiento Comercial Individual"},{ tipoestablecimiento:"Establecimiento Comercial Sociedad Anonima"} ],
        itemsTipoPropietario: [{tipopropietario: "Individual"},{ tipopropietario:"Individual"},{tipopropietario: "Juridico"},{ tipopropietario:"Juridico"}],
        itemsTipoSolicitud: [{tiposolicitud: "Solicitud Nueva "},{ tiposolicitud:"Modificación"}],
        tipoBItem: [{ tipodocumento: "DPI" }, { tipodocumento: "Constancia" }],
        itemsTipoParentesco: [
          { parentesco: "Casado", texto: "Casado con Guatemalteco/a" },
          { parentesco: "Unido", texto: "Unido de hecho con Guatemalteco/a" },
          { parentesco: "Hijos", texto: "Con hijos guatemaltecos/as" },
        ],
  
        itemsParentesco: [
          { parentesco: "Ninguno" },
          { parentesco: "Padres" },
          { parentesco: "Hermanos" },
          { parentesco: "Cónyuge" },
          { parentesco: "Hijos" },
          { parentesco: "Primos" },
          { parentesco: "Tios" },
        ],
        itemComboNacionalidades: [],
        itemComboDepartamentos: [],
        itemsComboEstable: [],
        itemComboSedes: [],
        itemComboMuncipio: [],
        itemComboMuncipio2: [],
        itemComboIdiomas: [],
        arrayIdiomas: [],
        coex: "",
        // Reglas
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
        
        modoEditar: false,
        fecha1: "",
        fecha2: "",
        fecha3: "",
        fecha_1: "",
        fecha_2: "",
        fecha_3: "",
        datosLaborales: false,
        datosLaboralesParte2: false,
        todos:false,
        datosAcademicos: false,
        datosCancela: false,
        requisitos_vector: [],
  
        itemsCombo: [
          { textos: "Gubernamental", valores: "1" },
          { textos: "Privada", valores: "2" },
          { textos: "Organización no gubernamental", valores: "3" },
          { textos: "Organismo internacional", valores: "4" },
          { textos: "Otros", valores: "5" },
  
        ],
  
        libro: {
          token: csrf_token,
          fecha_presentacion: "",
          nit: "",
          razonsocial: "",
          direccion: "",
          apartamento: "",
          zona: "",
          coloniabarrio: "",
          municipalidad: "",
          departamento: null,
          municipio: null,
          telefono: "",
          fax: "",
          correoelectronico: "",
          nombreestablecimiento: "",
          direccion2: "",
          numero_casa: "",
          zona_2: "",
          coloniabarrio2: "",
          municipio2: null,
          departamento2: null,
          sededepartamental: "",
          tipoestablecimiento: "",
          detalle: "",
          f63a: "",
          representantelegal: "",
          user_id: "",
          user_id: 0,
      };
    },
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
        .get("/libro/colocar/sede")
        .then((res) => {
          this.itemComboSedes = res.data;
        })
        .catch((error) => console.log(error));
  
      axios
        .get("/libro/colocar/tipo_establecimiento")
        .then((res) => {
          this.itemsComboEstable = res.data;
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
      
        this.libro.fecha_presentacion = "";
        this.libro.nit = "";
        this.libro.razonsocial = "";
        this.libro.direccion = "";      
        this.libro.apartamento = "";
        this.libro.zona = "";
        this.libro.coloniabarrio = "";
        this.libro.municipalidad = "";
        this.libro.departamento = null;
        this.libro.municipio = null;
        this.libro.telefono = "";
        this.libro.fax = "";
        this.libro.correoelectronico = "";
        this.libro.nombreestablecimiento = "";
        this.libro.direccion2 = "";
        this.libro.numero_casa = "";
        this.libro.zona_2 = "";
        this.libro.coloniabarrio2 = "";
        this.libro.municipio2 = null;
        this.libro.departamento2 = null;
        this.libro.sededepartamental = "";
        this.libro.tipoestablecimiento = "";
        this.libro.detalle = "";
        this.libro.f63a = "";
        this.libro.representantelegal = "";
  
  
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
      nextStep(step) {    
        if (step === 2 && this.$refs.form1.validate()) {
          this.currentStep = step;
        } 
        if (step === 3 && this.$refs.form2.validate()) {
          this.currentStep = step;
        }
      },
      prevStep() {
        if (this.currentStep > 1) {
          this.currentStep--;
        }
      },
      submitForm() {            
        /*axios
            .get("/libro/userid")
            .then((response) => {
              console.log("el ID de la solicitud update es: " + response.data);
              this.$toaster.success("Autenticacion correcta", { timeout: 500 });
              
              this.libro.user_id = response.data;
              console.log("ID del usuario actual: " + this.libro.user_id);                   
            })
            .catch((error) => console.log(error));
      
          */
         if (this.$refs.form3.validate()) {
          this.mModelAnimacion = true;
          axios
            .post("/libro/storeLibro", this.libro)
            .then((res) => {
              console.log("el ID de la solicitud update es: " + res.data);
              this.$toaster.success("Datos guardados correctamente", { timeout: 500 });
              console.log("DATA OK: " + res.data);
              this.mModelAnimacion = false;
              
              window.location.href =
                    "/expedientes/grid_libro?id=" +
                    res.data +
                    "&t1=" +
                    this.field.tipo1 +
                    "&t2=" +
                    this.field.tipo2;
            })
            .catch((error) => console.log(error));
         }  
      },
    regresar:function(){
        history.back();
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
        this.field.libro = "";
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
        console.log("El codigo de municipo " + this.libro.departamento);
        axios
          .put("solicitud/municipios", this.libro)
          .then((res) => {
            //alert(JSON.stringify(res.data));
            this.itemComboMuncipio = res.data;
          })
          .catch((error) => console.log(error));
      },
  
      onChangeDepartamento2() {
        console.log("El codigo de municipo " + this.libro);
        axios
          .put("solicitud/municipios", this.libro)
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
  
            
            var objFecha = new Date(response.data[0].fechaNacimiento);
  
            var diaNac = objFecha.getDate();
            if (diaNac.toString().length < 2) diaNac = "0" + diaNac;
            this.fecha1 = diaNac;
  
            var mesNac = objFecha.getMonth("m") + 1;
            if (mesNac.toString().length < 2) mesNac = "0" + mesNac;
            this.fecha2 = mesNac;
  
            var yearNac = objFecha.getFullYear();
            if (yearNac.toString().length < 2) yearNac = "0" + yearNac;
            console.log("fechaNac: " + response.data[0].estadocivil);
            this.fecha3 = yearNac;
  
            //this.field.fechaNacimiento = yearNac + "-" + mesNac + "-" + diaNac;
  
            const config = {
              headers: { "content-type": "multipart/form-data" },
            };
            console.log("El codigo de estudio " + response.data[0].nivelEstudio);
            let formData = new FormData();
            formData.append("nivelEstudio", response.data[0].nivelEstudio);
           
            axios
              .put("solicitud/municipios", this.field)
              .then((res) => {
                this.itemComboMuncipio = res.data;
                this.field.municipio = response.data[0].municipio;
              })
              .catch((error) => console.log(error));
           
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
  
  
  </style>
  
  