<template>
  <v-app id="inspire">
     
    <v-container>                       
    <div>
      <v-card color="blue-gray lighten-4">
        <v-card-text>
          <v-form ref="form" v-model="valid" lazy-validation>  
            <v-row>
                <v-col cols="12" md="4">
                  <v-text-field v-model="field.usuario" label="Escriba su nombre" required></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field v-model="field.telefono" label="Ingrese su # de Teléfono" required ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field v-model="field.correo"  label="E-mail" required></v-text-field>
                </v-col>
            </v-row>


            <v-row>
                <v-select v-model="field.respuesta1" :items="itemRes"
                    item-text="res" item-value="val"
                    filled label="Cómo le pareció el servicio prestado por nuestra  Institución?" 
                    multi-line></v-select>
            </v-row>
            <v-row>
                <v-select v-model="field.respuesta2" :items="itemRes"
                    item-text="res" item-value="val"
                    filled label="Cómo califica al conciliador en cuanto a su amabilidad y seguimiento oportuno a su tramite?" 
                    multi-line>
                </v-select>
            </v-row>
            <v-row>
                <v-select v-model="field.respuesta3" :items="itemRes"
                    item-text="res" item-value="val"
                    filled label="Cómo califica al conciliador en cuanto a su profesionalismo, Imparcialidad y Equidad al defender sus derechos?" 
                    multi-line>
                </v-select>
            </v-row>
            <v-row>
                <v-select v-model="field.respuesta4" :items="itemRes"
                    item-text="res" item-value="val"
                    filled label="Cómo califica  al conciliador en cuanto a la puntualidad al inicio de la audiencia y en la entrega del acta?" 
                    multi-line>
                </v-select>
            </v-row>
            <v-row>
                <v-select v-model="field.respuesta5" :items="itemRes"
                    item-text="res" item-value="val"
                    filled label="Cuál es su percepción en cuanto a nuestras instalaciones.?" 
                    multi-line>
                </v-select>
            </v-row>
            <v-row>
                <v-select v-model="field.respuesta6" :items="itemRes"
                    item-text="res" item-value="val"
                    filled label="Cómo califica la comunicación en el desarrollo del proceso de su queja?" 
                    multi-line>
                </v-select>
            </v-row>
            
            <v-row>
               <v-select v-model="field.conciliador" :items="itemCon"
                    item-text="conciliador" item-value="conciliador"
                    filled label="Seleccione el conciliador que lo atendio?" 
                    multi-line>
                </v-select>
                <v-col cols="12" md="4"> <v-text-field v-model="field.expediente" label="Expediente" required></v-text-field> </v-col>            
                <v-col cols="12" md="6"><v-textarea v-model="field.observaciones" background-color="grey lighten-2" color="orange orange-darken-4" label="Detalle la solicitud:"></v-textarea> </v-col>                                                           
            </v-row>

            <v-btn :disabled="!valid"  color="primary" class="mr-4" @click="agregar()">Ingresar encuesta</v-btn>         
            
            <div class='flotar'>         
              <div style='float: right;'>   
                <v-btn color="yellow darken-2" @click="regresar()" >Regresar</v-btn>                                     
              </div>               
            </div>

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
      field: [],      
      itemCon: [{ conciliador: "Edgar_Marroquin" }, { conciliador: "Antony_Alarcon" }, { conciliador: "Karen_Castañeda"}],      
      itemRes: [{ res: "Regular", val:1 }, { res: "Bueno", val:2 }, { res: "Excelente", val:3}],      
      field: {
        token: csrf_token,
        expediente: "",
        usuario: "",                
        telefono: "", 
        conciliador: "",       
        correo:"",
        respuesta1: "",
        respuesta2: "",
        respuesta3: "",
        respuesta4: "",
        respuesta5: "",
        respuesta6: "",
        observaciones: "",
        total: "",                       
      },
    };
  },
  created() {          
    this.field.expediente = "";
    this.field.usuario = "";
    this.field.telefono = "";
    this.field.conciliador = "";
    this.field.correo = "";
    this.field.respuesta1 = "";
    this.field.respuesta2 = "";
    this.field.respuesta3 = "";
    this.field.respuesta4 = "";
    this.field.respuesta5 = "";
    this.field.respuesta6 = "";
    this.field.observaciones = "";
    this.field.total = "";
    this.field.user_id = "";    
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
      
      
      /*const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      console.log("Enviando expediente: " + this.field.expediente);
      let formData = new FormData();
      formData.append("request", this.field);
      axios
        .post("/empresa/encuesta_con", formData, config)
        .then((res) => {
          console.log("el ID de la solicitud update es: " + res.data);
            this.$toaster.success("Encuesta Creada", { timeout: 2500 });
            console.log("DATA OK: " + res.data);
            this.mModelAnimacion = false;
        })
        .catch((error) => console.log(error));
*/
            
        axios
          .post("/empresa/encuesta_con", this.field)
          .then((res) => {
            console.log("Ejecucion exitosa: ");
            this.$toaster.success("Datos enviados exitosamente", { timeout: 500 });
            //console.log("DATA OK: " + res.data);            
            //window.location.href ="/"; 
            this.mModelAnimacion = false;  
            
            this.field.expediente = "";
            this.field.usuario = "";
            this.field.telefono = "";
            this.field.conciliador = "";
            this.field.correo = "";
            this.field.respuesta1 = "";
            this.field.respuesta2 = "";
            this.field.respuesta3 = "";
            this.field.respuesta4 = "";
            this.field.respuesta5 = "";
            this.field.respuesta6 = "";
            this.field.observaciones = "";
            this.field.total = "";
            this.field.user_id = "";    
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

