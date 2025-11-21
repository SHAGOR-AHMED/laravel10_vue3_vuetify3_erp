import './bootstrap';

import { createApp } from 'vue';

// Router
import router from './components/admin/js/routes'

// Vuex File
import store from './components/admin/js/store'

import common from './components/admin/js/common/mixin';

// Import Vuetify
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

// (Optional) import Material Design Icons
import '@mdi/font/css/materialdesignicons.css';

// Create Vuetify instance
const vuetify = createVuetify({
  components,
  directives,
});

// VueProgressBar
import Vue3Progress from "vue3-progress";

const options = {
  position: "fixed",
  height: "3px",
  color: '#66FE5E',
  thickness: '3px',
};

//vform
import { Form } from 'vform'

// tbl data not available
import DataNotAvailable from './components/admin/pages/common/data_not_available.vue';
// tbl data loader
import TblDataLoader from './components/admin/pages/common/tbl_loader.vue';
//login component
import LoginComponent from './components/Login.vue';
//admin index component
import IndexComponent from './components/admin/index.vue';
// pagination
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

//sweetalert2
import Swal from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp({});
app.component('data-not-available', DataNotAvailable);
app.component('tbl-data-loader', TblDataLoader);
app.component('login-component', LoginComponent);
app.component('index-component', IndexComponent);
app.component('Bootstrap5Pagination', Bootstrap5Pagination);
app.use(vuetify);
app.use(router);
app.use(store);
app.use(Swal);
app.mixin(common);
app.config.globalProperties.$form = Form
app.use(Vue3Progress, options);
app.mount('#app');