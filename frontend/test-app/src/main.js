import Vue from 'vue';
import App from './App.vue';

import { BootstrapVue } from 'bootstrap-vue';

import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import 'bootstrap-vue/dist/bootstrap-vue.css';



Vue.config.productionTip = false
Vue.prototype.$apiUrl = 'http://localhost:8000/api/';
Vue.use(BootstrapVue);

new Vue({
  render: h => h(App),
}).$mount('#app')
