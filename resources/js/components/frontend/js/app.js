
import './../../../bootstrap';

import { createApp } from 'vue';

// Router
import router from './routes'

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

import IndexComponent from './../index.vue';

const app = createApp({});
app.component('frontend-index-component', IndexComponent);
app.use(vuetify);
app.use(router);
app.mount('#app');

