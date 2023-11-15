<template>
<v-app id="inspire">
  <v-form @submit.prevent="generarReporte">
    <v-row>
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
        :data="tabla"
        :columns="headers"
        :file-name="'Reporte_Libro_Quejas'"
        :file-type="'xlsx'"
        :sheet-name="seletedPeriodo.toString()"
      >
        <i class="fa fa-download"> EXPORTAR</i>
      </vue-excel-xlsx>
      <br><br>
    <v-container>
         <v-form ref="form"  lazy-validation>     
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
            <v-data-table :headers="headers" :items="items" :search="search">
               <template v-slot:item="row">
                <tr>
                  <td>{{ row.item.sede }}</td>
                  <td>{{ row.item.enero }}</td>
                  <td>{{ row.item.febrero }}</td>
                  <td>{{ row.item.marzo }}</td>
                  <td>{{ row.item.abril }}</td>
                  <td>{{ row.item.mayo }}</td>
                  <td>{{ row.item.junio }}</td>
                  <td>{{ row.item.julio }}</td>
                  <td>{{ row.item.agosto }}</td>
                  <td>{{ row.item.septiembre }}</td>
                  <td>{{ row.item.octubre }}</td>
                  <td>{{ row.item.noviembre }}</td>
                  <td>{{ row.item.diciembre }}</td>
                  <td>{{ row.item.total }}</td>                           
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
        search: '',
        items: [],
        tabla: [],
        periodos: [],
        headers: [
          { text: 'Sede', value: 'sede', label:"Sede", field: "sede" },
          { text: "Enero", value: 'enero', label:"Enero", field: "enero" },
          { text: "Febrero", value: 'febrero', label:"Febrero", field: "febrero" },
          { text: "Marzo", value: 'marzo', label: "Marzo", field: 'marzo' },
          { text: "Abril", value: 'abril', label: "Abril", field: 'abril' },
          { text: "Mayo", value: 'mayo', label: "Mayo", field: 'mayo' },
          { text: "Junio", value: 'junio', label: "Junio", field: 'junio' },
          { text: "Julio", value: 'julio', label: "Julio", field: 'julio' },
          { text: "Agosto", value: 'agosto', label: "Agosto", field: 'agosto' },
          { text: "Septiembre", value: 'septiembre', label: "Septiembre", field: 'septiembre' },
          { text: "Octubre", value: 'octubre', label: "Octubre", field: 'octubre'    },
          { text: "Noviembre", value: 'noviembre', label: "Noviembre", field: 'noviembre'  },
          { text: "Diciembre", value: 'diciembre', label: "Diciembre", field: 'diciembre'  },
          { text: "Total", value: 'total', label: "Total", field: 'total'},
        ],
        seletedPeriodo: 0,
        downloadOption: false
      }
    },
    created: function() {
      axios
      .get("/libro/colocar/periodo")
      .then((res) => {
        this.periodos = res.data;
      })
      .catch((error) => console.log(error));

      axios
      .get("/empresa/solicitud/departamentos")
      .then((res) => {
        let sede_ = res.data;

        Promise.all(sede_.map((sed) => {
          this.tabla.push(
            {
              sede: sed.nombre,
              enero: 0,
              febrero: 0,
              marzo: 0,
              abril: 0,
              mayo: 0,
              junio: 0,
              julio: 0,
              agosto: 0,
              septiembre: 0,
              octubre: 0,
              noviembre: 0,
              diciembre: 0,
              total: 0
            }
          );
        }));        
      })
      .catch((error) => console.log(error));
    },
    methods: {  
      generarReporte() {
        const criteria_ = new FormData; 

        if ( this.seletedPeriodo > 0) {
          // Aquí puedes llamar a una función para generar el reporte con los parámetros seleccionados
          // Por ejemplo: this.$emit('generar-reporte', this.selectedMes, this.selectedSede);
          // Donde 'generar-reporte' sería un evento emitido hacia el componente padre
          criteria_.append('periodo', this.seletedPeriodo);

          axios.post('/libro/reportes', criteria_)
          .then((res) => {
            let tmpData = res.data;

            Promise.all(tmpData.map((dat) => {
              switch (dat.mes) {
                    case 1: 
                      this.tabla[dat.sede-1].enero = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 2: 
                      this.tabla[dat.sede-1].febrero = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 3: 
                      this.tabla[dat.sede-1].marzo = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 4: 
                      this.tabla[dat.sede-1].abril = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 5: 
                      this.tabla[dat.sede-1].mayo = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 6: 
                      this.tabla[dat.sede-1].junio = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 7: 
                      this.tabla[dat.sede-1].julio = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 8: 
                      this.tabla[dat.sede-1].agosto = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 9: 
                      this.tabla[dat.sede-1].septiembre = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 10:
                      this.tabla[dat.sede-1].octubre = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 11:
                      this.tabla[dat.sede-1].noviembre = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                    case 12: 
                      this.tabla[dat.sede-1].diciembre = dat.cantidad;
                      this.tabla[dat.sede-1].total += dat.cantidad;
                    break;
                  }
            }));

            this.items = this.tabla;
            this.downloadOption = true;
          })
          .catch((error) => console.log(error));
        } else {
          this.$toaster.error("Seleccionar PERIODO", { timeout: 5000 })
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