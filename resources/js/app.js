require('./bootstrap');
window.Vue = require('vue').default;
//window.Vue = require('vue');
//import Vuetify from "../plugins/vuetify"
//contrato_solicitud
import Toaster from 'v-toaster' 
import 'v-toaster/dist/v-toaster.css' 
import VueExcelXlsx from "vue-excel-xlsx";
Vue.use(Toaster, {timeout: 5000});
Vue.use(VueExcelXlsx);

Vue.component('inicio', require('./components/HomeComponent.vue').default);
Vue.component('grid_listado_empresa', require('./components/Empresa/grid_listado_empresa.vue').default);
Vue.component('webservice', require('./components/Empresa/webserviceSat.vue').default);
Vue.component('form_solicitud', require('./components/Solicitud/form_solicitud.vue').default);
Vue.component('contrato_solicitud', require('./components/Solicitud/contrato_solicitud.vue').default);
Vue.component('libro_solicitud', require('./components/Solicitud/libro_solicitud.vue').default);
Vue.component('rep_libro_fechas', require('./components/Solicitud/rep_libro_fechas.vue').default);
Vue.component('rep_contrato_fechas', require('./components/Solicitud/rep_contrato_fechas.vue').default);
Vue.component('libro_solicitud', require('./components/Solicitud/libro_solicitud.vue').default);

Vue.component('f63a_solicitud', require('./components/Solicitud/f63a_solicitud.vue').default);
Vue.component('grid_f63a_solicitud', require('./components/Solicitud/grid_f63a_solicitud.vue').default);

Vue.component('grid_f63a_solicitud', require('./components/Solicitud/grid_f63a_solicitud.vue').default);

Vue.component('pesas_solicitud', require('./components/Solicitud/pesas_solicitud.vue').default);
Vue.component('rep_pesas_fechas', require('./components/Solicitud/rep_pesas_fechas.vue').default);


Vue.component('ticket', require('./components/Solicitud/ticket.vue').default);
Vue.component('encuesta_con', require('./components/Solicitud/encuesta_con.vue').default);
Vue.component('grid_encuestas', require('./components/Solicitud/grid_encuestas.vue').default);
Vue.component('grid_expedientes', require('./components/Solicitud/grid_expedientes.vue').default);
Vue.component('grid_expedientes_libros', require('./components/Solicitud/grid_expedientes_libros.vue').default);
Vue.component('grid_expedientes_pesas', require('./components/Solicitud/grid_expedientes_pesas.vue').default);


Vue.component('grid_ticket', require('./components/Solicitud/grid_ticket.vue').default);
Vue.component('grid_ticket_report', require('./components/Solicitud/grid_ticket_report.vue').default);

Vue.component('form_solicitud_empresa_actualizar', require('./components/Solicitud/previoForma.vue').default);
Vue.component('form_requisitos_empresa', require('./components/Solicitud/form_requisitos_empresa..vue').default);
Vue.component('grid_expedientes_empresa', require('./components/Empresa/grid_expedientes_empresa.vue').default);


Vue.component('form_upload_file', require('./components/Adjuntos/form_upload_file.vue').default);
Vue.component('form_upload_file_contrato', require('./components/Adjuntos/form_upload_file_contrato.vue').default);
Vue.component('form_upload_file_pesa', require('./components/Adjuntos/form_upload_file_pesa.vue').default);



Vue.component('grid_mesa_trabajo', require('./components/Analista/grid_mesa_trabajo.vue').default);
Vue.component('grid_visor_expedientes', require('./components/Analista/grid_visor_expedientes.vue').default);
Vue.component('grid_visor_exp_instrumentos', require('./components/Analista/grid_visor_exp_instrumentos.vue').default);
Vue.component('grid_mesa_trabajo_dashboard', require('./components/Analista/grid_mesa_trabajo_dashboard.vue').default);

//Libros
Vue.component('rep_libro_consulta', require('./components/Solicitud/rep_libro_consulta.vue').default);
Vue.component('rep_libro_periodo', require('./components/Solicitud/rep_libro_periodo').default);
Vue.component('rep_libro_consulta_retro', require('./components/Solicitud/rep_libro_consulta_retro.vue').default);

Vue.component('gridbitacora', require('./components/Bitacora/gridbitacora.vue').default);


Vue.component('certificaciones', require('./components/Certificaciones/certificaciones.vue').default);
Vue.component('grafica-component', require('./components/graficos.vue').default);

const app = new Vue({
    //vuetify: Vuetify,      
    el: '#app'
});
