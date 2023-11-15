<template>
  <div class="small">
    <h4 align="center">Dashboard de Solicitudes</h4>
    <line-chart
      v-if="loaded"
      :chart-data="datacollection"
      :height="100"
    ></line-chart>
  </div>
</template>

<script>
import LineChart from "./LineChart.js";

export default {
  components: {
    LineChart,
  },
  data() {
    return {
      datacollection: null,
      loaded: false,
    };
  },
  async mounted() {
    this.loaded = false;
    var userlist = [];
    var labellist = [];
    try {

       
      await axios
        .get("/empresa/solicitud/listadoAnalistas", this.field)
        .then((res) => {
          console.log(
            "Resultado - - - - - - >  " + JSON.stringify(res.data, null, 2)
          );

          $.each(res.data, function (key, value) {
            userlist.push(value.total);
            labellist.push(value.name);
          });

          
        })
        .catch((error) => console.log(error));
      // const { userlist } = await fetch('/empresa/solicitud/nacionalidades')
      console.log("Respuesta: " + JSON.stringify(userlist));
      this.datacollection = {
        labels:labellist,
        datasets: [
          {
            label: "Ventas",
            backgroundColor: ["#FF0066","#DDD","#FF0066","#000"],
            data: userlist,
          },
        ],
      };

      // this.chartdata = userlist
      this.loaded = true;
    } catch (e) {
      console.error(e);
    }
  },
  methods: {
    fillData() {
      this.datacollection = {
        labels: [
          "Lunes",
          "Martes",
          "Miercoles",
          "Jueves",
          "Viernes",
          "Sabado",
          "Domingo",
        ],
        datasets: [
          {
            label: "Ventas",
            backgroundColor: [
              "#FCC066",
              "#BF0066",
              "#CF0066",
              "#DF0066",
              "#FF0466",
              "#FD0066",
            ],
            data: [20, 40, 50, 20, 50, 40],
          },
        ],
      };
    },
  },
};
</script>

<style lang="css">
.small {
  max-width: 800px;
  /* max-height: 500px; */
  margin: 50px auto;
}
</style>