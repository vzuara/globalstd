import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import vuetify from './plugins/vuetify';
import Vuelidate from 'vuelidate';
import axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

Vue.config.productionTip = false;

axios.interceptors.request.use(
  function (config) {
    const auth_token = localStorage.getItem('token');
    if (auth_token) {
      config.headers.Authorization = `Bearer ${auth_token}`;
    }
    return config;
  },
  function (err) {
    return Promise.reject(err);
  }
);

new Vue({
  router,
  store,
  vuetify,
  Vuelidate,
  render: (h) => h(App),
}).$mount('#app');
