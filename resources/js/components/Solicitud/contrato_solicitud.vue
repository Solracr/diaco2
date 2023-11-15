<template>
  <v-app id="inspire">
    <v-container>  
        
        <v-card color="blue-gray lighten-4">
          <h4>Formulario de contratos de Adhesión</h4>
          
          <!-- Stepper -->
          <v-stepper v-model="currentStep">
            <v-stepper-header>
              <!-- Pasos del Stepper -->
              <v-stepper-step :complete="currentStep > 1" step="1">Generar Boleta de Pago</v-stepper-step>
              <v-divider></v-divider>
              
              <v-stepper-step :complete="currentStep > 2" step="2">Cargar la boleta pagada</v-stepper-step>
              <v-divider></v-divider>
              
              <v-stepper-step :complete="currentStep > 3" step="3">Datos del Establecimiento</v-stepper-step>
              <v-divider></v-divider>
              
              <v-stepper-step :complete="currentStep > 4" step="4">Datos del Representante Legal o Propietario</v-stepper-step>
              <v-divider></v-divider>
              
              <v-stepper-step step="5"> Datos de Notificaciones</v-stepper-step>              
              
            </v-stepper-header>

            <!-- Contenido de los pasos -->
            <v-stepper-items>

              <!-- Paso 1 -->
              <v-stepper-content step="1">                                      
                      <v-form ref="form1" v-model="valid" lazy-validation> 
                        <v-text-field autocomplete="off" 
                        required
                        type="email"
                        v-model="correoNotificacion"  label="Escriba un correo para enviarle su orden de pago: "> </v-text-field>
                        <v-btn color="success" @click="generarBoleta()">Generar Boleta</v-btn>
                        <br><br>
                        <p>Despues de realizar su pago podra en cualquier agencia bancaria podra continuar con su tramite</p>
                       </v-form>
                       <v-btn color="primary" @click="nextStep(2)">Siguiente</v-btn>
              </v-stepper-content>
              
              <!-- Paso 2 -->
              <v-stepper-content step="2">
                <!-- Formulario del Paso 2 cargar archivos con API -->
                      <!--v-form ref="step1Form" v-model="isStep1Valid" lazy-validation-->
                      <v-form ref="form2" v-model="valid" lazy-validation>
                        <div>
                          <v-text-field autocomplete="off" type="number" v-model="voucher.noBoleta" label="Ingrese el número de boleta"> </v-text-field>
                          <!--<v-date-picker v-model="voucher.fechaPago"></v-date-picker>-->
                          <v-text-field v-model="voucher.fechaPago" label="Fecha de Boleta de Papo" type="date"></v-text-field>
                        </div>
                        <div>
                          <v-file-input v-model="voucher.voucherFile" label="Agregar Boleta"></v-file-input>
                          <v-btn  color="success" @click="uploadVoucher()"><i class="fa fa-file-upload" style="color:black"> Cargar</i></v-btn>
                        </div>
                       </v-form>
                       <br>
                       <!--<v-btn color="primary" @click="nextStep(3)">Siguiente</v-btn>-->
                       <v-btn @click="prevStep">Atrás</v-btn> <!-- Botón para regresar al paso anterior -->
              </v-stepper-content>

              <!-- Paso 3 -->
              <v-stepper-content step="3">                                      
                      <v-form ref="form3" v-model="valid" lazy-validation>                      
                        
                        <v-row>
                              <div v-if="normal">
                                <v-col cols="12" md="12">
                                  <v-select v-model="field.tipo_establecimiento" :items="itemsTipoEstablecimiento"
                                    item-text="tipoestablecimiento" item-value="tipoestablecimiento"
                                    
                                    
                                    label="Tipo de Establecimiento:" :disabled="isDisableedit()"
                                    :return-object="false" :rules="vacio" multi-line></v-select>
                                </v-col>
                              </div>
                            </v-row>  

                            <v-row>  
                              <v-col cols="12" md="12">
                                  <v-text-field @keyup="uppercase_nombre_establecimiento()" autocomplete="off" v-model="field.nombre_establecimiento" :disabled="isDisableedit()" label="Nombre del establecimiento"> </v-text-field>
                                </v-col>                
                            </v-row>
                            <v-row>
                                <v-col cols="12" md="6">
                                  <v-select v-model="field.profesion" :items="itemsTipoPropietario" item-text="tipopropietario" item-value="tipopropietario" filled label="Propietario:" :disabled="isDisableedit()" :return-object="false" :rules ="vacio" multi-line></v-select>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field autocomplete="off" v-model="field.nombreCompleto" :disabled="isDisableedit()" label="Nombre del Propietario"></v-text-field>
                                </v-col>                                                                 
                            </v-row>
                            

                        <v-row class="full-width">
                          <div v-if="field.profesion == 'Juridico'" class="full-width">
                              <v-col cols="12" md="12" class="full-width">
                                  <v-text-field autocomplete="off"  @keyup="razonSocialMayusculas()"
                                                v-model="field.razonSocial"
                                                :disabled="isDisableedit()" 
                                                label="Nombre del Representante Legal"
                                                class="full-width">
                                  </v-text-field>
                              </v-col>            
                          </div>
                      </v-row>


                      <v-row>
                        <v-col cols="12" md="6">
                          <v-text-field
                            autocomplete="off"
                            v-model="field.direccion"
                            :disabled="isDisableedit()"                  
                            label="Dirección del Establecimiento"
                            required
                          ></v-text-field>
                      </v-col>         
                      <v-col cols="12" md="3">
                        <v-select
                          v-model="field.departamento"
                          :items="itemComboDepartamentos"
                          item-text="nombre"
                          item-value="id"
                          label="Departamento del Establecimiento"
                          :return-object="false"
                          :disabled="isDisableedit()"
                          :rules="vacio"
                          single-line
                          @change="onChangeDepartamento()"
                        ></v-select>
                      </v-col>

                      <v-col cols="12" md="3">
                        <v-select
                          v-model="field.municipio"
                          :items="itemComboMuncipio"
                          item-text="nombre"
                          item-value="id"
                          label="Municipio del Establecimiento"
                          :return-object="false"
                          :disabled="isDisableedit()"
                          :rules="vacio"
                          single-line
                        ></v-select>
                      </v-col>                                                  
                  </v-row>
            

                </v-form>
                <v-btn color="primary" @click="nextStep(4)">Siguiente</v-btn>
                <v-btn @click="prevStep">Atrás</v-btn> <!-- Botón para regresar al paso anterior -->
              </v-stepper-content>

              <!-- Paso 4 -->
              <v-stepper-content step="4">                                
                <v-form ref="form4" v-model="valid" lazy-validation>                

                  <v-row>
                    <div v-if="normal">
                      <v-col cols="12" md="12">
                        <v-select
                          v-model="field.documentoIdentificacion"
                          :items="itemsTipoDocumento"
                          item-text="tipodocumento"
                          item-value="tipodocumento"
                          filled
                          label="Documento identificación"
                          :disabled="isDisableedit()"
                          :return-object="false"
                          :rules="vacio"
                          single-line
                        ></v-select>
                      </v-col>
                    </div>

                    <div v-if="tipoB">
                      <v-col cols="12" md="12">
                        <v-select
                          v-model="field.documentoIdentificacion"
                          :items="tipoBItem"
                          item-text="tipodocumento"
                          item-value="tipodocumento"
                          filled
                          label="Documento de Identificación"
                          :return-object="false"
                          :disabled="isDisableedit()"
                          :rules="vacio"
                          single-line
                        >
                        </v-select>
                      </v-col>
                    </div>

                    <div v-if="tipoG">
                      <v-col cols="12" md="12">
                        <v-select
                          v-model="field.documentoIdentificacion"
                          :items="tipoGItem"
                          item-text="tipodocumento"
                          item-value="tipodocumento"
                          filled
                          label="Documento Personal de Indentificación"
                          :return-object="false"
                          :disabled="isDisableedit()"
                          :rules="vacio"
                          single-line
                        >
                        </v-select>
                      </v-col>
                    </div>
                    <v-col
                      v-if="this.field.documentoIdentificacion == 'DPI'"
                      cols="12"
                      md="5"
                      ><v-text-field
                        filled
                        autocomplete="off"
                        v-model="field.numeroDocumento"
                        :rules="numberRuleDpi"
                        v-on:keypress="isNumber($event)"
                        :disabled="isDisableedit()"
                        label="Documento Personal de Identificación"
                        required
                      ></v-text-field
                    ></v-col>
                    <v-col
                      v-if="this.field.documentoIdentificacion != 'DPI'"
                      cols="12"
                      md="5"
                      ><v-text-field
                        filled
                        autocomplete="off"
                        v-model="field.numeroDocumento"
                        :disabled="isDisableedit()"
                        :rules="vacio"
                        label="Número de documento"
                        required
                      ></v-text-field
                    ></v-col>

                    <v-col
                      v-if="field.documentoIdentificacion == 'DPI'"
                      :disabled="isDisableedit()"
                      cols="12"
                      md="3"
                    >
                      <v-btn
                        @click="busquedacui()"
                        depressed
                        color="primary"
                        :disabled="isDisableedit()"
                        >Consultar DPI</v-btn
                      >
                    </v-col>
                  </v-row>

                  <v-row class="fill-height">                         
                    <v-col cols="12" md="4"
                      ><v-select
                        v-model="field.nacionalidad"
                        :items="itemComboNacionalidades"
                        item-text="GENTILICIO_NAC"
                        item-value="GENTILICIO_NAC"
                        label="Nacionalidad"
                        :disabled="isDisableedit()"
                        :return-object="false"
                        :rules="vacio"
                        single-line
                      ></v-select>
                    </v-col>
                    <v-col cols="12" md="4"
                      ><v-select
                        v-model="field.genero"
                        :items="itemsComboGenero"
                        item-text="genero"
                        item-value="genero"
                        label="Sexo"
                        :return-object="false"
                        :disabled="isDisableedit()"
                        :rules="vacio"
                        single-line
                      ></v-select>
                    </v-col>                   
                  </v-row>
          
                


                </v-form>
                <v-btn color="primary" @click="nextStep(5)">Siguiente</v-btn>
                <v-btn @click="prevStep">Atrás</v-btn> <!-- Botón para regresar al paso anterior -->
              </v-stepper-content>

              <!-- Paso 5 -->
              <v-stepper-content step="5">                                
                <v-form ref="form5" v-model="valid" lazy-validation>

                  <v-row>
                      <v-col cols="12" md="4">
                              <v-text-field
                                autocomplete="off"
                                v-model="field.correoElectronico"
                                :disabled="isDisableedit()"
                                :rules="emailRules"
                                label="Correo notificaciones"
                                required
                              ></v-text-field
                      ></v-col>            
                      
                      <v-col cols="12" md="4"
                              ><v-text-field
                                autocomplete="off"
                                v-model="field.numeroTelefono"
                                :rules="numberRule"
                                label="Teléfono de Notificaciones"
                                :disabled="isDisableedit()"
                                required
                              ></v-text-field
                          ></v-col>
                    </v-row>


                </v-form>
                <v-btn color="primary" @click="submitForm">Enviar</v-btn>
                <v-btn @click="prevStep">Atrás</v-btn> <!-- Botón para regresar al paso anterior -->
              </v-stepper-content>
            </v-stepper-items>
          </v-stepper>
        </v-card>            


    </v-container>




    <!-------Div modal---------->
    <div v-if="mModel">
      <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                
                <div class="modal-body">
                  
                  <v-row>
                    <v-col cols="12" md="3"
                      ><v-select
                        v-model="fecha1"
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
                        v-model="fecha2"
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
                        v-model="fecha3"
                        :items="itemfecha3"
                        item-text="codigo"
                        item-value="codigo"
                        label="Año"
                        :return-object="false"
                        :rules="vacio"
                        single-line
                      ></v-select
                    ></v-col>
                     <v-col cols="12" md="2"
                      >
                      <v-btn color="primary" class="mr-4" @click="seleccionar()"
                      >Seleccionar</v-btn
                    >
                    <v-btn color="primary" class="mr-4" @click="mModel = false"
                      >Cancelar</v-btn                    
                    ></v-col>
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


<!-------Div modal---------->
    <div v-if="cancelaModel">
      <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  Seleccione la fecha de teminación de labores
                </div>
                <div class="modal-body">
                  <br />
                  <v-row>
                    <v-col cols="12" md="3"
                      ><v-select
                        v-model="fechac1"
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
                        v-model="fechac2"
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
                        v-model="fechac3"
                        :items="itemfecha3"
                        item-text="codigo"
                        item-value="codigo"
                        label="Año"
                        :return-object="false"
                        :rules="vacio"
                        single-line
                      ></v-select
                    ></v-col>
                    <v-btn color="primary" class="mr-4" @click="seleccionarc()"
                      >Seleccionar</v-btn
                    >
                    <v-btn color="primary" class="mr-4" @click="cancelaModel = false"
                      >Cancelar</v-btn
                    >
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

    
    <div v-if="waitModel">
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
  },
  data() {
    return {
      msgU: "",
      step: 1, // Iniciar en el primer paso
      e1: 0,
      currentStep: 1,
      field1: '',
      field2: '',
      field3: '',
      isStep1Valid: false,
      isStep2Valid: false,
      isStep3Valid: false,
      requiredRule: [v => !!v || 'Este campo es requerido'],
      //csrf_token = $('meta[name="csrf-token"]').attr('content'),
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
      itemComboMuncipio: [],
      itemComboIdiomas: [],
      arrayIdiomas: [],
      coex: "",
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
      correoNotificacion: "",

      itemsCombo: [
        { textos: "Gubernamental", valores: "1" },
        { textos: "Privada", valores: "2" },
        { textos: "Organización no gubernamental", valores: "3" },
        { textos: "Organismo internacional", valores: "4" },
        { textos: "Otros", valores: "5" },

      ],

      field: {
        token: csrf_token,
        primerNombre: "",
        otrosNombres: "",
        primerApellido: "",
        otrosApellidos: "",
        apellidoCasada: "",
        nombreCompleto: "",
        numeroTelefono: "",
        fechaNacimiento: null,
        fechaCancelacion: null,
        motivo: null,
        nacionalidad: "",
        genero: "",
        estadoCivil: "",
        documentoIdentificacion: "",
        tipo_establecimiento:"",
        numeroDocumento: "",
        direccion: "",
        departamento: 0,
        municipio: 0,
        correoElectronico: "",
        tipoEntidad: "",
        profesion: "",
        nivelEstudio: "",
        especificarCarrera: "",
        experiencia: "",
        ocupacion: "",
        idiomas: "",
        observaciones: "n/a",
        razonSocial: "",

        situacionMigratoria: "",
        expedienteMigracion: "",
        llaveMigracion: "",

        nombrePlaza: "",
        perfilPlaza: "",
        funcionesGenerales: "",
        periodicidadPago: "",
        montoPago: 0,

        tipoParentesco: "",
        partida: "",
        folio: "",
        libro: "",
        certificadoCui: "",

        fechaIngreso: "",
        trabajoActual: "",
        ultimasOcupaciones: "",
        parientes: "",

        status: "",
        codigoEmpresa: 0,
        qr: "",

        tipo1: "",
        tipo2: "",
        expediente: "",
        user_id: "",
      },

      voucher: {
        noBoleta: "",
        fechaPago: "",
        voucherFile: null,
      }
    };
  },
  mounted() {
    //
  },
  created() {
    
  
    axios
      .get("/NivelacademicoController/index")
      .then((res) => {
        this.iniveEstudio = res.data;
      })
      .catch((error) => console.log(error));

    axios
      .get("/OcupacionController/index")
      .then((res) => {
        this.iOcupacion = res.data;
      })
      .catch((error) => console.log(error));

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
      .get("/empresa/solicitud/idiomas")
      .then((res) => {
        this.itemComboIdiomas = res.data;
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
    
    this.field.primerNombre = "";
    this.field.otrosNombres = "";
    this.field.primerApellido = "";
    this.field.otrosApellidos = "";
    this.field.apellidoCasada = "";
    this.field.nombreCompleto = "";
    this.field.numeroTelefono = "";
    this.field.fechaNacimiento = null;
    this.field.fechaCancelacion = null;
    this.field.motivo = "";
    this.field.nacionalidad = "";
    this.field.genero = "";
    this.field.estadoCivil = "";
    this.field.documentoIdentificacion = "";
    this.field.numeroDocumento = "";
    this.field.direccion = "";
    this.field.departamento = 0;
    this.field.municipio = 0;
    this.field.correoElectronico = "";
    this.field.tipoEntidad= "",
    this.field.profesion = "";
    this.field.nivelEstudio = "";
    this.field.especificarCarrera = "";
    //this.field.experiencia = "";
    this.field.ocupacion = "";
    this.field.idiomas = "";
    this.field.observaciones = "";
    this.field.nombre_establecimiento = "";
    this.field.tipo_solicitud = "";

    this.field.situacionMigratoria = "";
    this.field.expedienteMigracion = "";
    this.field.llaveMigracion = "";

    this.field.nombrePlaza = "";
    this.field.perfilPlaza = "";
    this.field.funcionesGenerales = "";
    this.field.periodicidadPago = "";
    this.field.montoPago = 0;

    //Boleta
    // this.voucher.noBoleta = "";
    // this.voucher.fechaPago = "";
    // this.voucher.voucherFile = null;

    this.tipoParentesco = "";
    this.partida = "";
    this.folio = "";
    this.libro = "";
    this.certificadoCui = "";

    this.correoNotificacion = "";

    this.fechaIngreso = "";
    this.trabajoActual = "";
    this.ultimasOcupaciones = "";
    this.parientes = "";

    this.field.status = "";
    this.field.codigoEmpresa = 0;
    this.field.qr = "";
    this.fecha1 = "";
    this.fecha2 = "";
    this.fecha3 = "";
    this.fechac1 = "";
    this.fechac2 = "";
    this.fechac3 = "";

    this.fecha_1 = "";
    this.fecha_2 = "";
    this.fecha_3 = "";

    this.especial = "";

    this.selectorSAT = "cui";

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
      if (step === 4 && this.$refs.form3.validate()) {
        this.currentStep = step;
      }
      if (step === 5 && this.$refs.form4.validate()) {
        this.currentStep = step;
      }
      
    },
    uploadVoucher: async function () {
      let rutaApi = "solicitud/cargar/boletaPago";
      const upload = new FormData;

      if (this.$refs.form1.validate()) {
        if (( this.voucher.voucherFile.type === 'image/jpeg' ) || ( this.voucher.voucherFile.type === 'application/pdf' )) {
          
          upload.append('noBoleta', this.voucher.noBoleta);
          upload.append('fechaPago', this.voucher.fechaPago);
          upload.append('selector', 'CA');
          upload.append('file', this.voucher.voucherFile);

          await axios.post(rutaApi, upload, { 
            // headers: { "Content-Type": "multipart/form-data" },
          }).then((response => (this.msgU = response.data))).catch( error => { console.log(error) });

          this.msgU ? [ 
            this.$toaster.success(`${this.msgU.message}`, { timeout: 4000 }),  
            this.nextStep(3),
          ] : [ 
            this.voucher.voucherFile = null, 
            this.$toaster.error("Ingrese la boleta nuevamente", { timeout: 4000 }) 
          ];

        } else {
          this.$toaster.error("Formato Admitido: jpeg o PDF", { timeout: 6000 }) 
        };
      } else {
        this.$toaster.error("Cargar Boleta Nuevamente", { timeout: 6000 }) 
      };
    },
    submitForm() {    
      //ref="form" v-model="valid"
      if (this.$refs.form3.validate()) {
        var rutaaccion = "solicitud/store";
        let rutaProc = "solicitud/boletaPago";
        //this.agregar();
        this.mModelAnimacion = true;
            axios
              .post(rutaaccion, this.field)
              .then((res) => {
                this.mModelAnimacion = false;
                console.log("el ID de la solicitud es: " + res.data);
                this.$toaster.success("Validación correcta", { timeout: 2500 });
                console.log("DATA OK: " + res.data);                

                this.mModelAnimacion = false;
                
                window.location.href =
                  "/requisitos/form_upload_file_contrato?id=" +
                  "&t1=" +
                  this.field.tipo1 +
                  "&t2=" +
                  this.field.tipo2;


                if (this.tipo2 !== "G" || this.tipo2 !== "B") {
                  //console.log('TRUE +++++++++ this.tipo2 !== G || this.tipo2 !== B ')
                  //window.location.href = '/requisitos/form_upload_file?id='+res.data+'&t1='+this.field.tipo1+'&t2='+this.field.tipo2;
                } else {
                  //console.log('FALSE -------- this.tipo2 !== G || this.tipo2 !== B ')
                  // ruta de refugiados
                }

                // requisitos es para empresa
                //window.location.href = '/requisitos?id='+res.data;
                // this.$router.push('/')
              })
              .catch((error) => console.log(error));
            
            axios.post(rutaProc, this.voucher).then((response) => {}).catch((error) => console.log(error));  
      }
    },  
    prevStep() {
      if (this.currentStep > 1) {
        this.currentStep--;
      }
    },
    regresar() {
      // Implementa la lógica para regresar a una página anterior o realizar acciones de regreso
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
          
          // Se asume que la codificación de Municipios y 
          // departamentos es la misma que esta publicada en 
          // http://goo.gl/EsxN1a

          // Listado de municipios actualizado segun:
          // http://goo.gl/QLNglm

          // Este listado contiene la cantidad de municipios
          // existentes en cada departamento para poder 
          // determinar el código máximo aceptado por cada 
          // uno de los departamentos.
          var munisPorDepto = [ 
              /* 01 - Guatemala tiene:      */ 17 /* municipios. */, 
              /* 02 - El Progreso tiene:    */  8 /* municipios. */, 
              /* 03 - Sacatepéquez tiene:   */ 16 /* municipios. */, 
              /* 04 - Chimaltenango tiene:  */ 16 /* municipios. */, 
              /* 05 - Escuintla tiene:      */ 13 /* municipios. */, 
              /* 06 - Santa Rosa tiene:     */ 14 /* municipios. */, 
              /* 07 - Sololá tiene:         */ 19 /* municipios. */, 
              /* 08 - Totonicapán tiene:    */  8 /* municipios. */, 
              /* 09 - Quetzaltenango tiene: */ 24 /* municipios. */, 
              /* 10 - Suchitepéquez tiene:  */ 21 /* municipios. */, 
              /* 11 - Retalhuleu tiene:     */  9 /* municipios. */, 
              /* 12 - San Marcos tiene:     */ 30 /* municipios. */, 
              /* 13 - Huehuetenango tiene:  */ 32 /* municipios. */, 
              /* 14 - Quiché tiene:         */ 21 /* municipios. */, 
              /* 15 - Baja Verapaz tiene:   */  8 /* municipios. */, 
              /* 16 - Alta Verapaz tiene:   */ 17 /* municipios. */, 
              /* 17 - Petén tiene:          */ 14 /* municipios. */, 
              /* 18 - Izabal tiene:         */  5 /* municipios. */, 
              /* 19 - Zacapa tiene:         */ 11 /* municipios. */, 
              /* 20 - Chiquimula tiene:     */ 11 /* municipios. */, 
              /* 21 - Jalapa tiene:         */  7 /* municipios. */, 
              /* 22 - Jutiapa tiene:        */ 17 /* municipios. */ 
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
          
          // Se verifica el correlativo con base 
          // en el algoritmo del complemento 11.
          var total = 0;          
          for (var i = 0; i < numero.length; i++)
          {
              total += numero[i] * (i + 2);
          }          
          var modulo = (total % 11);          
          console.log("CUI con módulo: " + modulo);
          return true;
          //return modulo === verificador;      
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
        /*this.$toaster.success('Puede continuar llenando la solicitud', {
            timeout: 2000,
        });*/
        //this.datosLaborales = false;
      }
       
    },
    busquedaBolsa() {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      if(this.field.tipo2 === "D")
      {
        if (this.field.nombrePlaza == "") {
              this.$toaster.error("Escriba el nombre de la plaza", {
                  timeout: 2000,
              });
              return false;
            }
            
            if (this.field.experiencia == null) {
              this.$toaster.error("Seleccione la experiencia", {
                  timeout: 2000,
              });
              return false;
            }
            if (this.field.tipoEntidad == null) {
              this.$toaster.error("Seleccione el Sector de Experiencia requerido", {
                  timeout: 2000,
              });
              return false;
            }
      }

      if (this.field.ocupacion == null) {
        this.$toaster.error("Seleccione la ocupacion", {
            timeout: 2000,
        });
        return false;
      }

       if (this.field.carrera == null) {
        this.$toaster.error("Seleccione la Carrera", {
            timeout: 2000,
        });
        return false;
      }

      if (this.field.idiomas == null) {
        this.$toaster.error("Seleccione Idioma", {
            timeout: 2000,
        });
        return false;
      }

       if (this.field.nivelEstudio == null) {
        this.$toaster.error("Seleccione el Nivel de Estudio", {
            timeout: 2000,
        });
        return false;
      }

      if (this.field.tipoEntidad == null) {
        this.$toaster.error("Seleccione el Sector de Experiencia requerido", {
            timeout: 2000,
        });
        return false;
      }

      

     /*
          'id_carrera' => 4,
          'id_ocupacion' => 444,
          'tipo_empresa' => 5,
          'id_experiencia' => 3,
          'id_idiomas' => 'Inglés'
     */
      
      let formData = new FormData();
      formData.append("id_carrera", this.field.carrera.id);
      formData.append("id_ocupacion", this.field.ocupacion.id);
      formData.append("id_experiencia", this.field.experiencia.id);
      formData.append("id_idiomas", this.field.idiomas);
      formData.append("id_empresa", this.field.codigoEmpresa);
      formData.append("nombre_plaza", this.field.nombrePlaza);
      formData.append("nivel_academico", this.field.nivelEstudio);
      formData.append("especial", this.especial);

      this.mModelAnimacion = true;
      console.log("Empresa para busqueda " + this.iOcupacion[this.field.nivelEstudio]);
      axios
        .post("/CarreraController/busquedaBolsa", formData, config)
        .then((response) => {
          
          var count = Object.keys(response.data).length;
          /*console.log(
            "Respuesta de la busqueda de bolsa cantidad de coincidencias ==>  " +
              count
          );*/
          //console.log(JSON.stringify(response.data));
          if (response.data === 'true') {

            this.mModelAnimacion = false;
            this.todos = false;
            this.modalActive = true;
            this.$toaster.error("Existen coincidencias en nuestra Base de Datos", {
              timeout: 2500,
            });            
          } else {

            this.mModelAnimacion = false;
            this.todos = true;
            this.datosLaborales = false;
            this.modalActivePositivo = true;
            this.$toaster.success("No se encontraron coincidencias. Continue llenando el formulario", {
              timeout: 3500,
            });
            
          }
          
        })
        .catch((error) => console.log(error));
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
      // console.log($event.keyCode); //keyCodes value
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      // only allow number and one dot
      if (
        (keyCode < 48 || keyCode > 57) &&
        (keyCode !== 46 || this.price.indexOf(".") != -1)
      ) {
        // 46 is dot
        $event.preventDefault();
      }
      // restrict to 2 decimal places
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
      this.field.fechaNacimiento =
        this.fecha3 + "-" + this.fecha2 + "-" + this.fecha1;
      console.log("Fecha: ===>>>>> " + this.field.fechaNacimiento);
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
      console.log("El codigo de municipo " + this.field.departamento);
      axios
        .put("solicitud/municipios", this.field)
        .then((res) => {
          this.itemComboMuncipio = res.data;
        })
        .catch((error) => console.log(error));
    },

    /*axios.post('/CarreraController/indexObtenerListado', {
              nivelEstudio: this.field.nivelEstudio.id,              
           }).then((response) => {    */

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
      if(this.motivo == "" || this.fechaCancelacion == "")
      {
        alert("Debe llenar todos los campos");        
        return;
      }
      var rutaaccion = "solicitud/store";
      if (this.field.codigoEmpresa.length > 7) {
        this.mModelAnimacion = true;
        rutaaccion = "solicitud/update";
        axios
          .post(rutaaccion, this.field)
          .then((res) => {
            console.log("el ID de la solicitud update es: " + res.data);
            this.$toaster.success("Exito", { timeout: 500 });
            console.log("DATA OK: " + res.data);
            this.mModelAnimacion = false;
            /**/
            
            window.location.href =
              "/requisitos/form_upload_file?id=" +
              res.data +
              "&t1=" +
              this.field.tipo1 +
              "&t2=" +
              this.field.tipo2;


            if (this.tipo2 !== "G" || this.tipo2 !== "B") {
              //console.log('TRUE +++++++++ this.tipo2 !== G || this.tipo2 !== B ')
              //window.location.href = '/requisitos/form_upload_file?id='+res.data+'&t1='+this.field.tipo1+'&t2='+this.field.tipo2;
            } else {
              //console.log('FALSE -------- this.tipo2 !== G || this.tipo2 !== B ')
              // ruta de refugiados
            }

            // requisitos es para empresa
            //window.location.href = '/requisitos?id='+res.data;
            // this.$router.push('/')
          })
          .catch((error) => console.log(error));
      }
    },
    generarBoleta(){      
      this.mModelAnimacion = true;
      axios.post("/registro/generarBoleta", { correo: this.correoNotificacion ,  concepto: "TRAMITE DE LA DIRECCION DE ATENCION Y ASISTENCIA AL CONSUMIDOR -DIACO- CONTRATO DE ADHESION" , tipo: "05" })
      .then((res) => {
          console.log("el ID de la solicitud update es: " + res.data);
          this.mModelAnimacion = false;
          this.$toaster.success("Datos enviados a su correo, proceda a pagar en el banco", { timeout: 3000 });
          this.correoNotificacion = "";
          this.nextStep(2);
          console.log("DATA OK: " + res.data);
         
      })
      .catch((error) => console.log(error));      
    },
    agregar() {
      //activa este 
      var rutaaccion = "solicitud/store";
      if (this.field.codigoEmpresa.length > 7) {
        this.mModelAnimacion = true;
        rutaaccion = "solicitud/update";
        axios
          .post(rutaaccion, this.field)
          .then((res) => {
            console.log("el ID de la solicitud update es: " + res.data);
            this.$toaster.success("Exito", { timeout: 500 });
            console.log("DATA OK: " + res.data);
            this.mModelAnimacion = false;
            /**/
            
            window.location.href =
              "/requisitos/form_upload_file?id=" +
              res.data +
              "&t1=" +
              this.field.tipo1 +
              "&t2=" +
              this.field.tipo2;


            if (this.tipo2 !== "G" || this.tipo2 !== "B") {
              //console.log('TRUE +++++++++ this.tipo2 !== G || this.tipo2 !== B ')
              //window.location.href = '/requisitos/form_upload_file?id='+res.data+'&t1='+this.field.tipo1+'&t2='+this.field.tipo2;
            } else {
              //console.log('FALSE -------- this.tipo2 !== G || this.tipo2 !== B ')
              // ruta de refugiados
            }
            // requisitos es para empresa
            //window.location.href = '/requisitos?id='+res.data;
            // this.$router.push('/')
          })
          .catch((error) => console.log(error));
      } else {
        
        if (this.$refs.form.validate()) {       
            if(this.field.tipo2 === "D")
            {     
              if (this.field.nombrePlaza == "") {
                this.$toaster.error("Escriba el nombre de la plaza", {
                    timeout: 2000,
                });
                return false;
              }
            }
          this.mModelAnimacion = true;
          /*this.field.ocupacion = this.field.ocupacion.id;
          this.field.experiencia = this.field.experiencia.id;
          this.field.carrera = this.field.carrera.id;
          console.log(this.field.idiomas);

          console.log("valor de la bandera " + this.validarIdiomas);*/
          var pattern = /^[0-9]$/;
          //if (this.field.idiomas.length > 0 || this.validarIdiomas) {
            var digitos13 = /^\d{13}$/;
            var prueba = this.field.numeroDocumento + "";
            if (this.field.documentoIdentificacion == "DPI") {
              if (!digitos13.test(this.field.numeroDocumento)) {
                this.$toaster.warning(
                  "Campo DPI debe contener 13 digitos, favor corregir",
                  { timeout: 4500 }
                );
                //alert("El DPI debe contener exactamente 13 digitos porfavor corregir el campo");
                return false;
              }
            }

            //this.field.idiomas = this.field.idiomas.join();
            this.mModelAnimacion = true;
            axios
              .post(rutaaccion, this.field)
              .then((res) => {
                this.mModelAnimacion = false;
                console.log("el ID de la solicitud es: " + res.data);
                this.$toaster.success("Validación correcta", { timeout: 2500 });
                console.log("DATA OK: " + res.data);                
                
                
                window.location.href =
                  "/requisitos/form_upload_file?id=" +
                  res.data +
                  "&t1=" +
                  this.field.tipo1 +
                  "&t2=" +
                  this.field.tipo2;


                if (this.tipo2 !== "G" || this.tipo2 !== "B") {
                  //console.log('TRUE +++++++++ this.tipo2 !== G || this.tipo2 !== B ')
                  //window.location.href = '/requisitos/form_upload_file?id='+res.data+'&t1='+this.field.tipo1+'&t2='+this.field.tipo2;
                } else {
                  //console.log('FALSE -------- this.tipo2 !== G || this.tipo2 !== B ')
                  // ruta de refugiados
                }

                // requisitos es para empresa
                //window.location.href = '/requisitos?id='+res.data;
                // this.$router.push('/')
              })
              .catch((error) => console.log(error));
          /*} else {
            this.$toaster.error("Debe ingresar los idiomas", { timeout: 3500 });
          }*/
        } 
        else 
        {
          this.$toaster.error("Debe ingresar todos los campos", {
            timeout: 3500,
          });
          this.mModelAnimacion = false;
        }
      }
    },
    fetchAllData: function () {
      
      this.todos = true;
      this.valid = false;
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      // axios
      //   .get("/listadoSolicitudesEmpresa", {
      //     action: "fetchall",
      //   })
      //   .then((response) => {
      //     this.items = response.data;
      //   });nombrePlaza
      //this.field.nombrePlaza = "Probando";
      let formData = new FormData();
      //var parametrosbs = [];
      //formData.append("status","PEX-D-1-2021");
      formData.append("dato", this.field.codigoEmpresa);
      console.log(
        "Codigo de empresa a editar - - - - - - >" + this.field.codigoEmpresa
      );
      var habilitarEdit=0;
      axios
            .post("/registro/obtenerUltimo", this.field)
            .then((res) => {
              //this.itemComboMuncipio = res.data;
              //this.field.municipio = response.data[0].municipio;
              //     console.log(
              //   "Resultado - - - - - - >  " +
              //     JSON.stringify(res.data, null, 2)
              // );
              
              if (res.data[0].evento_id == 8) {
                estadoedit = 1;
                
                // console.log(
                // "Resultado si - - - - - - >  " +
                //   JSON.stringify(res.data[0].evento_id, null, 2));
              }
              
            })
            .catch((error) => console.log(error));

      axios
        .put("/obtenerSolicitudesEmpresa", {
          nivelEstudio: this.field.codigoEmpresa,
        })
        .then((response) => {

          console.log(
            "Resultado - - - - - - >  " +
              JSON.stringify(response.data, null, 2)
          );
          
          //this.field.id = response.data[0].id;
          //this.items = response.data;
          //this.field.experiencia.values = this.field.experiencia.options[0];
          //this.field.idiomas = response.data[0].idiomas;
          //this.field.tipoEntidad = response.data[0].tipoEntidad;


          this.field.nombrePlaza = response.data[0].nombrePlaza;          
          this.field.experiencia = this.iexperiencia[0];
          this.field.ocupacion = this.iOcupacion[0];
          this.field.nivelEstudio = this.iniveEstudio[0];
          this.field.idiomas = response.data[0].idiomas;          
          this.field.documentoIdentificacion = response.data[0].documentoIdentificacion;
          this.field.numeroDocumento = response.data[0].numeroDocumento;
          this.field.primerNombre = response.data[0].primerNombre;
          this.field.otrosNombres = response.data[0].otrosNombres;
          this.field.primerApellido = response.data[0].primerApellido;
          this.field.otrosApellidos = response.data[0].otrosApellidos;
          this.field.apellidoCasada = response.data[0].apellidoCasada;
          this.field.nacionalidad = response.data[0].nacionalidad;
          this.field.numeroTelefono = response.data[0].numeroTelefono;
          this.field.genero = response.data[0].genero;
          this.field.estadoCivil = response.data[0].estadocivil;
          this.field.direccion = response.data[0].direccion;
          this.field.departamento = response.data[0].departamento;
          this.field.correoElectronico = response.data[0].correoElectronico;
          this.field.periodicidadPago = response.data[0].periodicidadPago;
          this.field.montoPago = response.data[0].montoPago;
          this.field.perfilPlaza = response.data[0].perfilPlaza;
          this.field.funcionesGenerales = response.data[0].funcionesGenerales;
          this.field.situacionMigratoria = response.data[0].situacionMigratoria;
          this.field.partida = response.data[0].partida;
          this.field.status = response.data[0].status;
          this.field.folio = response.data[0].folio;
          this.field.libro = response.data[0].libro;
          this.field.certificadoCui = response.data[0].certificadoCui;
          this.field.expediente = response.data[0].expediente;          
          this.field.tipoEntidad = this.itemsCombo[response.data[0].tipoEntidad-1];

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

          this.field.fechaNacimiento = yearNac + "-" + mesNac + "-" + diaNac;

          const config = {
            headers: { "content-type": "multipart/form-data" },
          };
          console.log("El codigo de estudio " + response.data[0].nivelEstudio);
          let formData = new FormData();
          formData.append("nivelEstudio", response.data[0].nivelEstudio);
          
          /*axios
            .post("/CarreraController/indexObtenerListado", formData, config)
            .then((response) => {
              this.iCarrera = response.data;
              this.field.carrera = this.iCarrera[0];              
            })
            .catch((error) => console.log(error));*/

          axios
            .put("solicitud/municipios", this.field)
            .then((res) => {
              this.itemComboMuncipio = res.data;
              this.field.municipio = response.data[0].municipio;
            })
            .catch((error) => console.log(error));
          //var values="Alto";

          

          // console.log(
          //   "Resultado - - - - - - >  " +
          //     JSON.stringify(this.iexperiencia, null, 2)
          // );
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

/*h4 {
      background-color: #001f3f;
      color: white;
    }*/

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

.vue-toasted.custom-toast {
  text-align: center;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

/* Ajusta el estilo de fondo del toastr si es necesario */
.vue-toasted.custom-toast .toasted {
  background-color: #4caf50; /* Cambia esto al color que prefieras */
  color: white;
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

