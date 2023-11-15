<template>
  <v-app id="inspire">
    <div class="container">
      <!--div class="card">
  <div class="card-header">Agregar Empresa</div>
  <p class="card-text"></p>
  <div class="card-body my-1"-->

      <!--form id="submit_form" @submit.prevent="submit_form"-->

      <v-container>
        <v-form ref="form" v-model="valid" lazy-validation>
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!--h4>Datos de la Empresa</h4-->
            <v-row
              ><v-col cols="12" md="6">
                <v-text-field
                  :rules="vacio"
                  v-model="fields.nit"
                  label="Escriba el NIT:"
                  required
                  :disabled="isDisableedit()"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-btn
                  color="primary"
                  class="mr-4"
                  @click="consultarNit()"
                  :disabled="isDisableedit()"
                  >Consultar NIT
                </v-btn>
              </v-col>
            </v-row>
            <v-row> </v-row>
          </nav>

          <v-card color="blue-gray lighten-4">
            <nav class="navbar navbar-dark bg-primary">
              <h4>Datos de la empresa</h4>
            </nav>
            <v-card-text>
              <v-row>
                <!--v-col cols="12" md="3"> <v-text-field :rules="cantidad" v-model="fields.nit" label="Nit" required></v-text-field></v-col-->
                <v-col cols="12" md="6">
                  <v-text-field
                    :rules="cantidad"
                    :disabled="habilitar == 0"
                    v-model="fields.razonSocial"
                    label="Razón Social"
                    required
                  ></v-text-field
                ></v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    :rules="cantidad"
                    v-model="fields.domicilio"
                    :disabled="isDisableedit()"
                    label="Dirección"
                    required
                  ></v-text-field
                ></v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="8">
                  <v-text-field
                    :rules="cantidad"
                    v-model="fields.actividadEconomica"
                    label="Actividad Económica"
                    required
                    disabled
                  ></v-text-field
                ></v-col>
                <v-col cols="12" md="4">
                  <v-select
                    :items="itemsCombo"
                    label="Tipo de entidad *"
                    class="md-4"
                    item-text="textos"
                    item-value="valores"
                    v-model="fields.tipoEntidad"
                    :disabled="isDisableedit()"
                    filled
                    required
                    :rules="rules.select"
                    @change="onChangeDepartamento()"
                    :menu-props="{ bottom: true, offsetY: true }"
                  ></v-select>
                  <!--v-select v-model="fields.tipoEntidad" :items="itemsCombo" item-text="textos" item-value="valores" label="Tipo de Entidad"  :return-object="false" :rules="cantidad" single-line ></v-select-->
                </v-col>
              </v-row>
              <v-row>
                <!--v-col cols="12" md="4"><v-text-field v-model="fields.telefono" :rules="vacio.concat(numberRule8)" v-on:keypress="isNumber($event)"  label="Teléfono" required></v-text-field></v-col-->
                <v-col cols="12" md="4"
                  ><v-text-field
                    v-model="fields.telefono"
                    :rules="numberRule8"
                    v-on:keypress="isNumber($event)"
                    label="Teléfono"
                    :disabled="isDisableedit()"
                    required
                  ></v-text-field
                ></v-col>
                <v-col cols="12" md="4"
                  ><v-text-field
                    v-model="fields.correo"
                    :rules="emailRules"
                    label="Correo"
                    :disabled="isDisableedit()"
                    required
                  ></v-text-field
                ></v-col>
                <v-col class="d-flex" cols="12" md="4">
                  <v-select
                    :items="itemComboDepartamentos"
                    label="Departamento *"
                    class="md-4"
                    item-text="nombre"
                    item-value="id"
                    v-model="fields.departamento"
                    filled
                    required
                    :disabled="isDisableedit()"
                    :rules="rules.select"
                    @change="onChangeDepartamento()"
                    :menu-props="{ bottom: true, offsetY: true }"
                  ></v-select>
                  <!--v-select v-model="fields.departamento" :items="itemComboDepartamentos" item-text="nombre" item-value="id"  filled label="Departamento"  @change="onChangeDepartamento()"> </v-select-->
                  <!--multiselect v-model="fields.departamento" :options="itemComboDepartamentos" :custom-label="Departamento" placeholder="Seleccione una opción" label="Departamento"  track-by="name"></multiselect-->
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="4">
                  <v-select
                    :items="itemComboMuncipio"
                    label="Municipio *"
                    class="md-4"
                    item-text="nombre"
                    item-value="id"
                    v-model="fields.municipio"
                    :disabled="isDisableedit()"
                    filled
                    required
                    :rules="rules.select"
                    @change="onChangeDepartamento()"
                    :menu-props="{ bottom: true, offsetY: true }"
                  ></v-select>
                </v-col>
                <!--v-col cols="12" md="4"><v-select v-model="fields.municipio" :items="itemComboMuncipio" item-text="nombre" item-value="id" label="Municipio" :return-object="false" single-line></v-select></v-col-->
                <v-col cols="12" md="4">
                  <!--v-text-field
                    :rules="numberRule4.concat(vacio)"
                    v-on:keypress="isNumber($event)"
                    v-model="fields.cantidadTrabajadores"
                    :disabled="isDisableedit()"
                    label="Cantidad Trabajadores"
                    required
                  -->
                  <v-text-field                    
                    v-on:keypress="isNumber($event)"
                    v-model="fields.cantidadTrabajadores"
                    :disabled="isDisableedit()"
                    label="Cantidad Trabajadores"                    
                  >
                  </v-text-field
                ></v-col>
              </v-row>
            </v-card-text>
          </v-card>

          <br />

          <v-card color="blue-gray lighten-4">
            <!--nav class="navbar"  style="background:#001f3f;   "-->
            <nav class="navbar navbar-dark bg-primary">
              <h4>Datos del Representante Legal</h4>
            </nav>
            <v-card-text>
              <v-row>
                <v-col cols="12" md="4">
                  <!--label for="jack">DPI</label>
            <input type="checkbox" id="" value="1" v-model="dpi_check"-->
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="flexRadioDefault"
                      id="flexRadioDefault1"
                      @click="input1()"
                      :disabled="isDisableedit()"
                      :checked="this.c1 == true"
                    />
                    <label class="form-check-label" for="flexRadioDefault1">
                      Nit Representante
                    </label>
                  </div>
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="flexRadioDefault"
                      id="flexRadioDefault2"
                      @click="input2()"
                      :disabled="isDisableedit()"
                      :checked="this.c2 == true"
                    />
                    <label class="form-check-label" for="flexRadioDefault2">
                      CUI Representante
                    </label>
                  </div>
                </v-col>

                <div v-if="c1">
                  <v-col cols="12" md="12">
                    <v-text-field
                      v-model="fields.nitRepresentante"
                      label="NIT Representante"
                      :disabled="isDisableedit()"
                    ></v-text-field>
                  </v-col>
                </div>
                <div v-if="c2">
                  <v-col cols="12" md="12">
                    <v-text-field
                      v-model="fields.nitRepresentante"
                      label="CUI Representante"
                      :disabled="isDisableedit()"
                    ></v-text-field>
                  </v-col>
                </div>

                <v-col cols="12" md="4">
                  <v-btn
                    @click="consultarRepresentante()"
                    :disabled="isDisableedit()"
                    depressed
                    color="primary"
                    >Consultar Representante</v-btn
                  >
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3">
                  <v-text-field
                    @keyup="primerNombreRepresentanteUpperCase()"
                    :rules="cantidad"
                    v-model="fields.primerNombreRepresentante"
                    :disabled="isDisableedit()"
                    label="Primer Nombre"
                    required
                  ></v-text-field
                ></v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    @keyup="otrosNombresRepresentanteUpperCase()"
                    v-model="fields.otrosNombresRepresentante"
                    label="Otros Nombres"
                    :disabled="isDisableedit()"
                  ></v-text-field
                ></v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    @keyup="primerApellidoRepresentanteUpperCase()"
                    v-model="fields.primerApellidoRepresentante"
                    label="Primer Apellido"
                    :disabled="isDisableedit()"
                  ></v-text-field
                ></v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    @keyup="segundoApellidoRepresentanteUpperCase()"
                    v-model="fields.segundoApellidoRepresentante"
                    label="Otros Apellidos"
                    :disabled="isDisableedit()"
                  ></v-text-field
                ></v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="4"
                  ><v-text-field
                    :rules="cantidad"
                    @keyup="uppercase_cargo()"
                    v-model="fields.cargo"
                    :disabled="isDisableedit()"
                    label="Cargo"
                    required
                  ></v-text-field
                ></v-col>
              </v-row>
            </v-card-text>
          </v-card>
          <br />
          <v-btn
            :disabled="!valid"
            color="primary"
            class="mr-4"
            @click="registrarEmpresa"
            >Registrar Empresa
          </v-btn>
          <v-btn
            :disabled="!isDisableedit()"
            :visible="isDisableedit()"
            color="primary"
            class="mr-4"
            @click="editar"
            >Editar</v-btn
          >
          <v-alert v-model="alert" dismissible type="error"
            >Debe completar el formulario</v-alert
          >
        </v-form>
      </v-container>
      <!--/form-->

      <div id="xy" style="display: none">
        <img :src="'/img/loading.gif'" />
      </div>
      <div v-if="mModel">
        <transition name="model">
          <div class="modal-mask">
            <!--div class="modal-wrapper">
       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-body"-->
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
            <!--/div>
        </div>
       </div>
      </div-->
          </div>
        </transition>
      </div>
      <!--DIV CONTAINER FINAL-->
    </div>
  </v-app>
</template>

<script>
import Vuetify from "vuetify";
import Multiselect from "vue-multiselect";
import "vuetify/dist/vuetify.min.css";
var recargaedit = 0;

export default {
  vuetify: new Vuetify(),
  components: {
    Multiselect,
  },
  data() {
    return {
      habilitar: 0,
      valid: false,
      rules: {
        select: [(v) => !!v || "Debe hacer clic para seleccionar un dato"],
        select2: [
          (v) =>
            v.length > 0 || "Es requerido seleccionar un dato de esta lista",
        ],
      },
      //{ name: 'Vue.js', language: 'JavaScript' }
      c1: false,
      c2: false,
      idEmpresa: "",
      selectorSAT: "",
      itemComboDepartamentos: [],
      itemComboMuncipio: [],
      snackbar: false,
      text: "El NIT ingresado no es válido",
      alert: false,

      numberRule: [
        (v) => Number.isInteger(Number(v)) || "Debe ingresar un valor numerico",
        (v) => v.length == 8 || "El valor debe ser de 8 digitos",
      ],
      emailRules: [
        (v) =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "Escriba una dirección de E-mail",
      ],
      vacio: [(v) => !!v || "Debe ingresar un dato"],
      numberRule: [
        (v) => Number.isInteger(Number(v)) || "Debe ingresar un valor numerico",
        (v) => v.length <= 8 || "El número debe ser menor o igual a 8 digitos",
      ],
      cantidad: [(v) => !!v || "Debe ingresar un dato"],
      numberRule4: [
        (v) => Number.isInteger(Number(v)) || "Debe ingresar un valor numerico",
        (v) => v.length <= 4 || "El número debe ser menor o igual a 4 digitos",
      ],
      numberRule8: [
        (v) => Number.isInteger(Number(v)) || "Debe ingresar un valor numerico",
        (v) => v.length <= 8 || "El número debe ser igual a 8 digitos",
      ],
      combos: [
        "Sociedad_Mercantil",
        "Empresa_Individual",
        "Entidad_No_Lucrativa",
      ],
      mModel: false,
      fields: [],
      csrf: document.head.querySelector('meta[name="csrf-token"]')
        ? document.head.querySelector('meta[name="csrf-token"]').content
        : "",
      modoEditar: false,

      itemsCombo: [
        { textos: "Sociedad Mercantil", valores: "Sociedad_Mercantil" },
        { textos: "Empresa Individual", valores: "Empresa_Individual" },
        { textos: "Entidad No Lucrativa", valores: "Entidad_No_Lucrativa" },
      ],

      fields: {
        nit: "",
        razonSocial: "",
        domicilio: "",
        correo: "",
        telefono: "",
        actividadEconomica: "",
        nitRepresentante: "",
        tipoEntidad: "",
        direccionNotificaciones: "NAN",
        cantidadTrabajadores: "",
        cargo: "",
        departamento: 0,
        municipio: 0,
        user_id: "",
        primerNombreRepresentante: "",
        otrosNombresRepresentante: "",
        primerApellidoRepresentante: "",
        segundoApellidoRepresentante: "",
        nacionalidad: "EXTRANJERO",
      },
    };
  },

  created() {
    this.valid = false;
    //this.$refs.form.reset();
    axios
      .get("/empresa/solicitud/departamentos")
      .then((res) => {
        this.itemComboDepartamentos = res.data;
      })
      .catch((error) => console.log(error));

    this.habilitar = 0;
    this.nit = "";
    this.razonSocial = "";
    this.domicilio = "";
    this.correo = "";
    this.telefono = "";
    this.actividadEconomica = "";
    this.nitRepresentante = "";
    this.primerNombreRepresentante = "";
    this.otrosNombresRepresentante = "";
    this.primerApellidoRepresentante = "";
    this.segundoApellidoRepresentante = "";
    this.tipoEntidad = "";
    this.direccionNotificaciones = "NAN";
    this.cantidadTrabajadores = "";
    this.cargo = "";
    this.departamento = 0;
    this.municipio = 0;
    if (!this.csrf) {
      console.warn(
        'The CSRF token is missing. Ensure that the HTML header includes the following: <meta name="csrf-token" content="{{ csrf_token() }}">'
      );
    }
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
    this.idEmpresa = parametros[1].codigo;
    this.fetchAllData();
  },
  computed: {
    axiosParams() {
      const params = new URLSearchParams();
      params.append("nit", this.fields.nit);
      //params.append('param2', 'value2');
      return params;
    },
  },

  methods: {
    isLetterOrNumber(e) {
      let char = String.fromCharCode(e.keyCode);
      if (/^[A-Za-z0-9]+$/.test(char)) return true;
      else e.preventDefault();
    },
    isNumber(e) {
      let char = String.fromCharCode(e.keyCode);
      if (/^[z0-9]+$/.test(char)) return true;
      else e.preventDefault();
    },
    input1() {
      this.selectorSAT = "nit";
      this.c1 = true;
      this.c2 = false;
      this.$toaster.warning("Selecciono: " + this.selectorSAT, {
        timeout: 500,
      });
    },
    input2() {
      this.selectorSAT = "cui";
      this.c2 = true;
      this.c1 = false;
      this.$toaster.warning("Selecciono: " + this.selectorSAT, {
        timeout: 500,
      });
      //this.$toaster.warning('Cui Seleccionado',{timeout: 2500})
    },
    consultarRepresentante() {
      //this.$toaster.warning('Iniciar consulta de representante',{timeout: 2500})
      this.mModel = true;
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      let formData = new FormData();
      formData.append("selector", this.selectorSAT);
      formData.append("dato", this.fields.nitRepresentante);
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
            this.fields.primerNombreRepresentante =
              response.data.contribuyente.primerNombreRepresentante;
            this.fields.otrosNombresRepresentante =
              response.data.contribuyente.otrosNombresRepresentante;
            this.fields.primerApellidoRepresentante =
              response.data.contribuyente.primerApellidoRepresentante;
            this.fields.segundoApellidoRepresentante =
              response.data.contribuyente.segundoApellidoRepresentante;
            this.mModel = false;
            this.valid = true;
            this.$toaster.success("Datos recuperados Exitosamente.", {
              timeout: 1500,
            });
          } else {
            this.mModel = false;
            //this.snackbar=true
            this.valid = true;
            this.$toaster.error("NIT Incorrecto.", { timeout: 2500 });
          }
        });
    },
    onChangeDepartamento() {
      console.log("El codigo de departamento " + this.fields.departamento);
      axios
        .put("/solicitud/municipios", this.fields)
        .then((res) => {
          this.itemComboMuncipio = res.data;
        })
        .catch((error) => console.log(error));
    },
    primerNombreRepresentanteUpperCase() {
      this.fields.primerNombreRepresentante =
        this.fields.primerNombreRepresentante.toUpperCase();
    },
    otrosNombresRepresentanteUpperCase() {
      this.fields.otrosNombresRepresentante =
        this.fields.otrosNombresRepresentante.toUpperCase();
    },
    primerApellidoRepresentanteUpperCase() {
      this.fields.primerApellidoRepresentante =
        this.fields.primerApellidoRepresentante.toUpperCase();
    },
    segundoApellidoRepresentanteUpperCase() {
      this.fields.segundoApellidoRepresentante =
        this.fields.segundoApellidoRepresentante.toUpperCase();
    },
    uppercase_cargo() {
      this.fields.cargo = this.fields.cargo.toUpperCase();
    },
    validate() {
      //  this.$refs.form.validate(),
      this.$refs.submit_form.validate();
    },
    registrarEmpresa() {
      /*if(this.fields.nit === '' || this.fields.cantidadTrabajadores === '' || this.fields.razonSocial === '' || this.fields.cargo === '' || this.fields.tipoEntidad === ''){                              
              this.$toaster.warning('Debe ingresar todos los campos',{timeout: 2500})        
            }else{            
          }*/
      this.$refs.form.validate();
      if (this.valid) {
        if (this.idEmpresa > 0) {
            this.fields.idEmpresa=this.idEmpresa;
            axios.post("actualizarEmpresa", this.fields).then((response) => {
            console.log(response.data);
            this.$toaster.success("La Empresa fue actualizada Exitosamente", {
              timeout: 2500,
            });
            window.location.href = "/empresa/solicitud";
            //this.$router.push('/Empresa')
            //this.$router.push('/')
          });
        }
        else{
          axios.post("registrarEmpresa", this.fields).then((response) => {
            console.log(response.data);
            this.$toaster.success("La Empresa fue registrada Exitosamente", {
              timeout: 2500,
            });
            window.location.href = "/empresa/solicitud";
            //this.$router.push('/Empresa')
            //this.$router.push('/')
          });
        }
      } else {
        this.$toaster.error(
          "Debe llenar el formulario con todos los datos solicitados",
          { timeout: 2500 }
        );
      }
    },
    editar() {
      recargaedit = 0;
      this.$forceUpdate();
    },
    isDisableedit() {
      return recargaedit > 0;
    },
    consultarNit() {
      if (this.fields.nit == "") {
        this.$toaster.warning("Debe ingresar el numero de NIT", {
          timeout: 1500,
        });
        this.mModel = false;
        this.$refs.form.validate();
      } else {
        this.mModel = true;
        axios
          .get("consultarNit", {
            params: this.axiosParams,
          })
          .then((response) => {
            console.log(
              "RX ==== - - - - - - >  " + JSON.stringify(response, null, 2)
            );
            //this.$toaster.success('Datos recuperados Exitosamente.' + response.data, {timeout: 1500})
            if (response.data.code == "200") {
              console.log(response.data);
              this.fields = response.data.contribuyente;
              if (response.data.contribuyente.tipo == "individual") {
                this.habilitar = 1;
              } else {
                this.habilitar = 0;
              }
              this.mModel = false;
              this.valid = true;
              this.$toaster.success("Datos recuperados Exitosamente.", {
                timeout: 1500,
              });
            } else {
              this.mModel = false;
              //this.snackbar=true
              this.valid = true;
              this.$toaster.error("NIT Incorrecto.", { timeout: 2500 });
            }
          })
          .catch((error) => console.log(error));
      } // fin del Else

      //.finally(() => this.mModel=false)
    },
    agregar() {
      if (
        this.fields.cargo.trim() === "" ||
        this.fields.cantidadTrabajadores.trim() === ""
      ) {
        this.$toaster.warning("Debe ingresar todos los campos", {
          timeout: 2500,
        });
        return;
      }
      const nNueva = this.fields;
      this.fields = { nit: "", nombre: "", domicilio: "" };
      axios.post("empresa/store", nNueva).then((res) => {
        const fieldsServidor = res.data;
        this.fields.push(fieldsServidor);
      });
    },
    cancelarEdicion() {
      this.modoEditar = false;
      this.fields = { nit: "", nombre: "", domicilio: "" };
    },
    fetchAllData: function () {
      console.log(
        "Resultado - - - - - - >  " + JSON.stringify(this.idEmpresa, null, 2)
      );
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("dato", this.idEmpresa);
      axios
        .post("/empresa/consultarEmpresa", {
          idEmpresa: this.idEmpresa,
        })
        .then((response) => {
          //this.items = response.data;
          this.fields.nit = response.data[0].nit;
          this.fields.razonSocial = response.data[0].razonSocial;
          this.fields.domicilio = response.data[0].domicilio;
          this.fields.actividadEconomica = response.data[0].actividadEconomica;
          this.fields.razonSocial = response.data[0].razonSocial;
          this.fields.tipoEntidad = response.data[0].tipoEntidad;
          this.fields.telefono = response.data[0].telefono;
          this.fields.correo = response.data[0].correo;
          this.fields.departamento = response.data[0].departamento;
          console.log("Campo de departamento");
          console.log(this.fields.departamento);
          this.fields.cantidadTrabajadores =
            response.data[0].cantidadTrabajadores;
          this.fields.primerNombreRepresentante =
            response.data[0].primerNombreRepresentante;
          this.fields.otrosNombresRepresentante =
            response.data[0].otrosNombresRepresentante;
          this.fields.primerApellidoRepresentante =
            response.data[0].primerApellidoRepresentante;
          this.fields.segundoApellidoRepresentante =
            response.data[0].segundoApellidoRepresentante;
          this.fields.cargo = response.data[0].cargo;
          this.fields.nitRepresentante = response.data[0].nitRepresentante;

          axios
            .put("solicitud/municipios", this.fields)
            .then((res) => {
              console.log(res.data);
              this.itemComboMuncipio = res.data;
              this.field.municipio = response.data[0].municipio;
            })
            .catch((error) => console.log(error));

          this.fields.municipio = response.data[0].municipio;
          if (this.fields.nitRepresentante.length > 11) {
            this.c2 = true;
            this.c1 = false;
          } else {
            this.c1 = true;
            this.c2 = false;
          }

          if (this.idEmpresa > 0) {
            recargaedit = 1;
          }
          // //var values="Alto";

          //  console.log(
          //    "Resultado - - - - - - >  " +
          //      JSON.stringify(response.data[0], null, 2)
          //  );
        });
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
</style>

