<template>
<<<<<<< HEAD
  <v-app id="inspire">
    
    
    <v-container>
    <v-data-table
      :headers="headers"
      :items="items"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Registros</v-toolbar-title>
          <v-spacer></v-spacer>
                                
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark v-on="on">Exportar a XLSX</v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">Exportar Datos</span>
              </v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="exportToExcel">Exportar</v-btn>
                <v-btn color="grey" text @click="dialog = false">Cancelar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>


        </v-toolbar>
      </template>
    </v-data-table>
  </v-container>


   
  </v-app>
</template>
<script>
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "vuejs-datepicker-module/dist/vuejs-datepicker.css";

import * as XLSX from 'xlsx';




export default {
  vuetify: new Vuetify(),
  components: {    
  },
  data() {
    return {
      dialog: false,
      headers: [
        { text: 'Recibo', value: 'recibo' },
        { text: 'Regional', value: 'regional' },
        { text: 'Fecha', value: 'fecha' },
        { text: 'Consumidor', value: 'consumidor' },
        { text: 'Lugar', value: 'lugar' },
        { text: 'Depósito', value: 'deposito' },
        { text: 'Rubro', value: 'rubro' },
        { text: 'Cantidad', value: 'cantidad' },
        { text: 'Oficina', value: 'oficina' },
        { text: 'Creado en', value: 'created_at' },
        { text: 'Actualizado en', value: 'updated_at' },
      ],            
      items: [
        {
          recibo: "",
        regional: "",
          fecha: "",
          consumidor: "",
          lugar: "",
          deposito: "",
          rubro: "",
          cantidad: "",
          oficina: "",
          updated_at: "",
          created_at: "",
          id: 0
        }       
      ]   
    };
  },  
  created: function() {
      console.log('montando componente');      
      this.fetchAllData();
    },
  methods: {
    resetForm() {      
    },
    exportToExcel() {      
      const ws = XLSX.utils.json_to_sheet(this.items);      
      const wb = XLSX.utils.book_new();      
      XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');            
      XLSX.writeFile(wb, 'f63a_report.xlsx');   
      this.dialog = false;   
    },
    
    fetchAllData: function() {                          
      axios.post('/f63a/get')
      .then((response) =>{                                    
        this.items = response.data;           
        console.log("Respuesta exp: " +  JSON.stringify(response.data,null,2));       
        this.downloadOption = true;
      });
    },       
  }
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

=======
    <v-app id="inspire">
      
      
      <v-container>
      <v-data-table
        :headers="headers"
        :items="items"
        class="elevation-1"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Registros</v-toolbar-title>
            <v-spacer></v-spacer>
                                  
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark v-on="on">Exportar a XLSX</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">Exportar Datos</span>
                </v-card-title>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="green darken-1" text @click="exportToExcel">Exportar</v-btn>
                  <v-btn color="grey" text @click="dialog = false">Cancelar</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
  
  
          </v-toolbar>
        </template>
      </v-data-table>
    </v-container>
  
  
     
    </v-app>
  </template>
  <script>
  import Vuetify from "vuetify";
  import "vuetify/dist/vuetify.min.css";
  import "vuejs-datepicker-module/dist/vuejs-datepicker.css";
  
  import * as XLSX from 'xlsx';
  
  
  
  
  export default {
    vuetify: new Vuetify(),
    components: {    
    },
    data() {
      return {
        dialog: false,
        headers: [
          { text: 'Recibo', value: 'recibo' },
          { text: 'Regional', value: 'regional' },
          { text: 'Fecha', value: 'fecha' },
          { text: 'Consumidor', value: 'consumidor' },
          { text: 'Lugar', value: 'lugar' },
          { text: 'Depósito', value: 'deposito' },
          { text: 'Rubro', value: 'rubro' },
          { text: 'Cantidad', value: 'cantidad' },
          { text: 'Oficina', value: 'oficina' },
          { text: 'Creado en', value: 'created_at' },
          { text: 'Actualizado en', value: 'updated_at' },
        ],            
        items: [
          {
            recibo: "",
          regional: "",
            fecha: "",
            consumidor: "",
            lugar: "",
            deposito: "",
            rubro: "",
            cantidad: "",
            oficina: "",
            updated_at: "",
            created_at: "",
            id: 0
          }       
        ]   
      };
    },  
    created: function() {
        console.log('montando componente');      
        this.fetchAllData();
      },
    methods: {
      resetForm() {      
      },
      exportToExcel() {      
        const ws = XLSX.utils.json_to_sheet(this.items);      
        const wb = XLSX.utils.book_new();      
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');            
        XLSX.writeFile(wb, 'f63a_report.xlsx');   
        this.dialog = false;   
      },
      
      fetchAllData: function() {                          
        axios.post('/f63a/get')
        .then((response) =>{                                    
          this.items = response.data;           
          console.log("Respuesta exp: " +  JSON.stringify(response.data,null,2));       
          this.downloadOption = true;
        });
      },       
    }
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
  
  
>>>>>>> d0850ca8e03bcd9df297446a98e3d52681dae4e3
