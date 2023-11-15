<template>
  <v-app id="inspire">
    <v-container>     
    <div >
      <v-card>
        
        <v-card-text>
          <v-form ref="form" v-model="valid" lazy-validation>  
            <div>
             
                <h4>Solicitud de Soporte Técnico</h4>
             
              <v-row>
                <v-col cols="12" md="3"><v-text-field 
                  autocomplete="off" v-model="field.nombre"  label="Nombre:"
                  required></v-text-field></v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3"><v-text-field 
                  autocomplete="off" v-model="field.subject"  label="Correo Eléctronico (notificaciones):"
                  required></v-text-field></v-col>
              </v-row>
              
            
               <v-row>
                <v-col cols="12" md="6"><v-textarea v-model="field.message" background-color="grey lighten-2"
                    color="orange orange-darken-4" label="Describa su solicitud de soporte técnico:"></v-textarea>
                </v-col>                                                           
              </v-row>

              <v-col cols="12" md="3"> 
              <v-select
                      v-model="field.sede"
                      :items="listaSede"
                      item-text="sede"
                      item-value="sede"
                      label="Sede Regional"
                      :return-object="false"                        
                      single-line
                    >
              </v-select>
              </v-col>
              <v-col cols="12" md="3"> 
              <v-select
                      v-model="field.departamento"
                      :items="listaDepartamento"
                      item-text="sede"
                      item-value="sede"
                      label="Departamento"
                      :return-object="false"                        
                      single-line
                    >
              </v-select>
              </v-col>
              

            </div>

            

              <v-btn :disabled="!valid"  color="primary" class="mr-4" @click="agregar()">Crear Ticket</v-btn>         
              
          </v-form>
        </v-card-text>
      </v-card>
    </div>
    </v-container>


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
//import VueMaterialDateTimePicker from 'vue-material-date-time-picker';
import Vuetify from "vuetify";
//import 'vue-search-select/dist/VueSearchSelect.css'
//import { ModelSelect } from 'vue-search-select'
import "vuetify/dist/vuetify.min.css";
import Multiselect from "vue-multiselect";
import Datepicker from "vuejs-datepicker-module";
import "vuejs-datepicker-module/dist/vuejs-datepicker.css";
var csrf_token = $('meta[name="csrf-token"]').attr("content");

export default {
  vuetify: new Vuetify(),
  components: {
    Datepicker,
    Multiselect,
  },
  data() {
    return {
      //csrf_token = $('meta[name="csrf-token"]').attr('content'),
      mModelAnimacion:false,
      valid: true,
      listaSede: [{ sede: "Central" }, { sede: "Chimaltenango" }, { sede: "Jutiapa" }, { sede: "San_Marcos" }, { sede: "Suchitepequez" },
       { sede: "Jalapa" }, { sede: "Coban" }, { sede: "Chiquimula" }, { sede: "Escuintla" }, { sede: "Huehuetenango" },
       { sede: "Izabal" }, { sede: "Peten" }, { sede: "Quetzaltenango" }, { sede: "Quiche" }, { sede: "Totonicapan" },
       { sede: "Zacapa" }, { sede: "Sacatepequez" }, { sede: "Baja_Verapaz" }, { sede: "Solola" }, { sede: "Retalhuleu" },
       { sede: "Mixco" }, { sede: "VillaNueva" }, { sede: "El_Progreso" }, { sede: "Santa_Rosa" }],
       listaDepartamento: [{ sede: "VERIFICACION" }, { sede: "ATENCION_CONSUMIDOR" }, { sede: "FINANCIERO" }, { sede: "ADMINISTRACION" }, { sede: "SEDES_REGIONALES" },
       { sede: "DIRECCION" }, { sede: "JURIDICO" }, { sede: "ATENCION_PROVEEDOR" }, { sede: "GESTION_CALIDAD" }, { sede: "INVENTARIOS" }],
      field: [],
      itemsComboGenero: [{ genero: "Hombre" }, { genero: "Mujer" }],      
      field: {
        token: csrf_token,
        subject: "",
        nombre: "",
        message: "",        
        status: "",                
        user_id: "",
        sede:"",
        departamento:"",
      },
    };
  },
  created() {          
    this.field.subject = "";
    this.field.message = "";    
    this.field.nombre = "";    
    this.field.status = "";  
    this.mModelAnimacion = false;
    
    this.fetchAllData();
  },
  computed: {    
  },

  methods: {
    regresar:function(){
      history.back();
    },
       agregar() {
      this.mModelAnimacion = true;           
      
  
            
        axios
          .post("/empresa/ticket_add", this.field)
          .then((res) => {
            console.log("Ejecucion exitosa: ");
            this.$toaster.success("Ticket generado exitosamente", { timeout: 1900 });
            
            this.mModelAnimacion = false;        
            this.field = '';
            
          })
          .catch((error) => console.log(error));                   
    },       
    fetchAllData: function () {                  
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

</style>

