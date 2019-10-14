import Vue from "vue";
import router from "./router";
import store from "./store";
require("./bootstrap");


import VueNoty from 'vuejs-noty';
Vue.use(VueNoty, {
  timeout: 1500,
  progressBar: true,
});

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use(CKEditor);

import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

// import axios from 'axios'
var axiosInstance = axios.create({
  // baseURL: '',
});
axiosInstance.interceptors.request.use(function (config) {
  // assume your access token is stored in local storage
  // (it should really be somewhere more secure but I digress for simplicity)
  if(store.state.auth.user && store.state.auth.user.loggedIn){
    let token = store.state.auth.user.api_token;
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`
    }
  }
  return config;
}, function (error) {
  // Do something with request error
  // console.log(error);
  return Promise.reject(error);
});

axiosInstance.interceptors.response.use(function (response) {
  // console.log(response);
  return response;
}, function (error) {
  console.error(error);
  if (error.response.status == 401) {
    store.commit("_loggedIn", false);
    location.assign("/");
  } else {
    return Promise.reject(error);
  }
});

import VueAxios from 'vue-axios'
Vue.use(VueAxios, axiosInstance)

// import VueSocialauth from 'vue-social-auth'

// Vue.use(VueSocialauth, {
//   providers: {
//     facebook: {
//       clientId: '387359618573580',
//       redirectUri: 'https://lapor.tabalongkab.go.id/auth/facebook/callback' // Your client app URL
//     }
//   }
// });

// import VueQrcode from '@chenfengyuan/vue-qrcode';
// Vue.component(VueQrcode.name, VueQrcode);

import ImageUploader from 'vue-image-upload-resize'
Vue.use(ImageUploader);

Vue.config.productionTip = false;

// const printer = new AKThermalPrinter();
// Vue.prototype.$printer = printer;

import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
  name: '_blank',
  specs: [
    'fullscreen=no',
    'titlebar=no',
    'scrollbars=no'
  ],
  styles: [
    '/css/style.css',
  ]
};

Vue.use(VueHtmlToPaper, options);

import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton);

//global registration
// import VueTabs from 'vue-nav-tabs'
// import 'vue-nav-tabs/themes/vue-tabs.css'
// Vue.use(VueTabs);

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/id'
Vue.use(ElementUI,{locale});

new Vue({
  router,
  store,
}).$mount("#app");
