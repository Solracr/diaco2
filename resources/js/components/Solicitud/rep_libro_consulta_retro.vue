<template>
  <v-container>
    <v-form @submit.prevent="generarReporte">
      <v-row>
        <!--<v-col cols="12" md="4">
          <v-select
            v-model="selectedMes"
            :items="meses"
            label="Seleccionar Mes"
          ></v-select>
        </v-col>
        <v-col cols="12" md="4">
          <v-select
            v-model="selectedSede"
            :items="sedes"
            label="Seleccionar Sede"
          ></v-select>
        </v-col>-->
        <v-col cols="12" md="4">
          <v-text-field v-model="nit" label="Nit"></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field v-model="razonsocial" label="Razon Social"></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field v-model="patente" label="Patente"></v-text-field>
        </v-col>
      </v-row>
      <br>
      <v-btn type="submit" color="success"><i class="fa fa-search"> Buscar</i></v-btn>
      <br><br>
      <v-card>
        <v-card-title>
          <div class='flotar'>
            <div style='float: left;'>
              <v-text-field v-model="search" label="Buscar" single-line hide-details></v-text-field>  
            </div>
            <div style='float: right;'>                    
            </div>               
          </div>              
        </v-card-title>
        <v-data-table :headers="headers" :items="items">
          <template v-slot:item="row">
            <tr>
              <td>{{row.item.patente}}</td>
              <td>{{row.item.nit}}</td>
              <td>{{row.item.razonsocial}}</td>
              <td>{{row.item.empresa}}</td>
              <td>{{row.item.libro}}</td>                                    
              <td>{{row.item.fecha}}</td>
              <td>{{row.item.status}}</td>                                      
            </tr>
          </template>
        </v-data-table>
      </v-card>
    </v-form>
  </v-container>
</template>

<script>
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
      
export default {
  vuetify: new Vuetify(), 
  data() {
    return { 
      search: '',     
      nit: null,
      razonsocial: null,
      patente: null,
      items: [],
      headers: [          
          { text: 'Patente', value: 'patente' },
          { text: 'Nit', value: 'nit' },
          { text: 'Razon Social', value: 'razonsocial' },
          { text: 'Empresa', value: 'empresa' },
          { text: 'Resolución', value: 'resolucion' },
          { text: 'Fecha', value: 'fecha' },          
          { text: 'Estatus', value: 'status' },           
      ], 
      // selectedMes: null,
      // selectedSede: null,
      // meses: [
      //         { text: "Enero", value: "enero" },
      //         { text: "Febrero", value: "febrero" },
      //         { text: "Marzo", value: "marzo" },
      //         { text: "Abril", value: "abril" },
      //         { text: "Mayo", value: "mayo" },
      //         { text: "Junio", value: "junio" },
      //         { text: "Julio", value: "julio" },
      //         { text: "Agosto", value: "agosto" },
      //         { text: "Septiembre", value: "septiembre" },
      //         { text: "Octubre", value: "octubre" },
      //         { text: "Noviembre", value: "noviembre" },
      //         { text: "Diciembre", value: "diciembre" },
      //       ],
      // sedes: [
      //   { text: "Ciudad de Guatemala", value: "guatemala" },
      //   { text: "Quetzaltenango", value: "quetzaltenango" },
      //   { text: "Quiché", value: "quiche" },
      //   { text: "Huehuetenango", value: "huehuetenango" },
      //   { text: "Sacatepéquez", value: "sacatepequez" },
      //   { text: "Alta Verapaz", value: "alta-verapaz" },
      //   { text: "Baja Verapaz", value: "baja-verapaz" },
      //   { text: "Chimaltenango", value: "chimaltenango" },
      //   { text: "Chiquimula", value: "chiquimula" },
      //   { text: "El Progreso", value: "el-progreso" },
      //   { text: "Escuintla", value: "escuintla" },
      //   { text: "Izabal", value: "izabal" },
      //   { text: "Jalapa", value: "jalapa" },
      //   { text: "Jutiapa", value: "jutiapa" },
      //   { text: "Petén", value: "peten" },
      //   { text: "Retalhuleu", value: "retalhuleu" },
      //   { text: "San Marcos", value: "san-marcos" },
      //   { text: "Santa Rosa", value: "santa-rosa" },
      //   { text: "Sololá", value: "solola" },
      //   { text: "Suchitepéquez", value: "suchitepequez" },
      //   { text: "Totonicapán", value: "totonicapan" },
      //   { text: "Zacapa", value: "zacapa" }
      //   // Puedes seguir agregando más departamentos si es necesario
      // ],

    };
  },
  methods: {
    generarReporte() {
      const data_ = new FormData;
      if (this.nit || this.patente || this.razonsocial) {
          data_.append('nit', this.nit);
          data_.append('patente', this.patente);
          data_.append('rSocial', this.razonsocial);

          axios.post('/libro/consultar/libros_old', data_, { 
            // headers: { "Content-Type": "multipart/form-data" },
          }).then((response) =>{                                    
            this.items = response.data;    
          }).catch( error => { console.log(error) });
      } else {
        this.$toaster.error("Ingrese Un Parametro", { timeout: 4000 })
      }
    },
  },
};
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

