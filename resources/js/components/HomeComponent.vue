<template>
    <!--div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Bienvenidos</div>

                    <div class="card-body">
                        I'm an example component in Vue js.
                    </div>
                </div>
            </div>
        </div>
    </div-->
    <v-app id="inspire">
     <v-container>
         <v-form ref="form" v-model="valid" lazy-validation>     
          <v-card>            
            <v-card-title>                
            <br>            
            </v-card-title>
              <div>
                        <h2 align='center'>Sistema de Control -DIACO EN LINEA- V2.0 </h2>
              </div>
              <div>                 
                <p align="center"><img src="/img/pexx.png" width="150" height="150"></p>                 
              </div>            
            
          
          </v-card>
         </v-form>
     </v-container>
     </v-app>
</template>

<script>

    import Vuetify from "vuetify";
    import "vuetify/dist/vuetify.min.css";


    export default {
        vuetify: new Vuetify(),
        data(){
            mostrar1:false;
            return{
                
            }
        },
        mostrar1(){
            alert('que puchis mucha');
        },
        mounted() {

        },
        components: {Vuetify}
    }
</script>
