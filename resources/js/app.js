require('./bootstrap');
import Vue from 'vue'
import App from './App.vue'
import store from './store'
import Vuex from 'vuex';

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css'

Vue.config.productionTip = false
Vue.use(Vuex);

new Vue({
  store,
  render: h => h(App)
}).$mount('#app')
