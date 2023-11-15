<template>
<v-app id="inspire">
  <v-form v-model="valid">
    <v-container>
         <v-form ref="form" v-model="valid" lazy-validation>     
          <v-card>
          <v-card-title>              
                  <div class='flotar'>
                    <div style='float: right;'>
                        <v-text-field
                        v-model="search"
                        
                        label="Buscar"
                        single-line
                        hide-details
                      ></v-text-field>  
                    </div>
                    <div style='float: left;'>
                        
                         <v-btn color="primary" @click="empresa()" dark>Agregar Empresa
                          <v-icon dark right>fa fa-check</v-icon>
                        </v-btn>
                          
                        
                  </div>               
                </div>
            </v-card-title>
            <v-data-table
              :headers="headers"
              :items="items"
              :search="search">

               <template v-slot:item="row">
                <tr>
                  <td>{{row.item.nit}}</td>
                  <td>{{row.item.razonSocial}}</td>
                  <td>{{row.item.domicilio}}</td>
                  <td>{{row.item.telefono}}</td>
                  <td>{{row.item.correo}}</td>
                  <td>
                    <v-btn color="primary" x-small @click="redirect(row.item.id)" dark>Nueva Solicitud</v-btn>
                    <v-btn color="primary" x-small @click="redirectProrroga(row.item.id)" >Prorroga</v-btn>
                    <v-btn color="primary" x-small @click="editarEmpresa(row.item.id)" dark>Ver</v-btn>
                    <!--router-link :to="{ path: '/Form_Solicitud', params: { IdEmpresa: row.item.id }}">
                    <v-btn color="primary" dark>Nueva Solicitud                          
                        </v-btn>                          
                    </router-link-->
                  </td>
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
    data () {
      return {
        search: '',
        valid:false,
        headers: [
          {
            text: 'NIT',
            align: 'start',
            filterable: false,
            value: 'nit',
          },
          { text: 'Razón Social', value: 'razonSocial' },
          { text: 'Dirección', value: 'domicilio' },
          { text: 'Teléfono', value: 'telefono' },
          { text: 'Correo', value: 'correo' },
          { text: 'Acción', value: 'solicitud' },
        ],
        items: [
          {
            id: '',
            nit: '',
            razonSocial: '',
            domicilio: '',
            telefono: '',
            correo: '',                      
          },        
        ],
      }
    },
    created: function() {
      console.log('montando componente');
      this.fetchAllData();
    },
     methods: {      
        empresa: function(event){                     
          window.location.href = "/empresa/webservice?type="+1+"&empresaId=0";        
        },
        editarEmpresa: function(id){                     
          window.location.href = "/empresa/webservice?type="+1+"&empresaId="+id;        
        },
        redirect: function(id){                               
          window.location.href = "/empresa/form_solicitud?IdEmpresa="+id+"&tipo1=Solicitud&tipo2=D";
          //this.$router.push({name:'home', params: {id: '[paramdata]'}});
        },
         redirectProrroga: function(id){                               
          window.location.href = "/empresa/form_solicitud?IdEmpresa="+id+"&tipo1=Prorroga&tipo2=D";
        },
        greet: function (event) {                  
          if (event) {
            alert(event.target.tagName)
          }
        },
        fetchAllData: function() {          
          axios.get('listadoEmpresas', {
            action: 'fetchall'
          }).then((response) => {                    
            this.items = response.data;            
            //console.log(this.allData);            
          });
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

</style>
