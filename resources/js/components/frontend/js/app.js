
require('./../../../bootstrap');

window.Vue = require('vue').default;

// Router
import router from './routes'

// Vuex File
//import store from './store';

// mixin global added
// import common from './common/mixin';
// Vue.mixin(common);

// Vuetify
import Vuetify from 'vuetify'
Vue.use(Vuetify)

Vue.component('frontend-index-component', require('./../index.vue').default);

const app = new Vue({
  router,
  vuetify: new Vuetify(),
  
}).$mount('#app')

