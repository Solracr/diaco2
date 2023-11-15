<template>
  <v-app id="inspire">
    <v-form @submit.prevent="generarReporte">
      <v-row>
        <v-col cols="12" md="4">
          <v-select
            v-model="selectedMes"
            :items="meses"
            label="Seleccionar Mes"
          ></v-select>
        </v-col>
          <v-col cols="12" md="4" lg="3">
            <v-select
              v-model="seletedPeriodo"
              :items="periodos"
              item-text="periodo"
              item-value="periodo"
              label="Periodo" 
              single-line
            ></v-select>
          </v-col>
        </v-row>
        <br>
        <v-btn type="submit" color="success"><i class="fa fa-table"> Generar</i></v-btn>
        <vue-excel-xlsx class="btn warning" v-if="downloadOption == true"
        :data="items"
        :columns="headers"
        :file-name="'Reporte_Instrumentos_'+selectedMes+'_'+seletedPeriodo.toString()"
        :file-type="'xlsx'"
        :sheet-name="'Hoja 1'"
        >
        <i class="fa fa-download"> EXPORTAR</i>
        </vue-excel-xlsx>
        <br><br>
      <v-container>
           <v-form ref="form"  lazy-validation>     
            <v-card>
              <v-data-table :headers="headers" :items="items">
                 <template v-slot:item="row">
                  <tr>
                    <td>{{ row.item.mes }}</td>
                    <td>{{ row.item.cantidad }}</td>                           
                  </tr>
              </template>
              </v-data-table>
            </v-card>        
      </v-form>
      </v-container>
    </v-form>
  </v-app>
  </template>
  
  <script>
  import Vuetify from "vuetify";
  import "vuetify/dist/vuetify.min.css";
  
  
  export default {
      vuetify: new Vuetify(),  
      indicador:'',  
      data () {
        return {
          items: [
            {
              mes:'',
              cantidad: null,          
            },
          ],
          periodos: [],
          sedes: [],
          headers: [          
            { text: 'Mes', value: 'mes', label: 'Mes', field: 'mes' },
            { text: 'Cantidad', value: 'cantidad', label: 'Cantidad', field: 'cantidad' }          
          ],
          selectedMes: null,
          selectedSede: null,
          seletedPeriodo: 0,
          meses: [
            { text: "Enero", value: 1 },
            { text: "Febrero", value: 2 },
            { text: "Marzo", value: 3 },
            { text: "Abril", value: 4 },
            { text: "Mayo", value: 5 },
            { text: "Junio", value: 6 },
            { text: "Julio", value: 7 },
            { text: "Agosto", value: 8 },
            { text: "Septiembre", value: 9 },
            { text: "Octubre", value: 10 },
            { text: "Noviembre", value: 11 },
            { text: "Diciembre", value: 12 },
          ],
          downloadOption: false
        }
      },
      created: function() {
        axios
        .get("/pesa/colocar/periodo")
        .then((res) => {
          this.periodos = res.data;
        })
        .catch((error) => console.log(error));
      },
       methods: {  
        generarReporte() {
          const criteria_ = new FormData; 
          if (this.selectedMes && (this.seletedPeriodo > 0)) {
            // Aquí puedes llamar a una función para generar el reporte con los parámetros seleccionados
            // Por ejemplo: this.$emit('generar-reporte', this.selectedMes, this.selectedSede);
            // Donde 'generar-reporte' sería un evento emitido hacia el componente padre
            criteria_.append('periodo', this.seletedPeriodo);
            criteria_.append('sede', this.selectedSede);
            criteria_.append('mes', this.selectedMes);
  
            axios.post('/pesa/reporte', criteria_)
            .then((res) => {
              this.items[0].mes = res.data.mes;
              this.items[0].cantidad = res.data.cantidad;
            })
            .catch((error) => console.log(error));
            this.downloadOption = true;
          } else {
            this.$toaster.error("Seleccionar MES y PERIODO", { timeout: 5000 })
          }
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
  