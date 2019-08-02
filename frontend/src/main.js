import Vue from 'vue'
import App from './App.vue'

import './plugins/vuetify'
import 'roboto-fontface/css/roboto/roboto-fontface.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import router from './router'
import store from './store'
import axios from './Api'

import VueEditor from "vue2-editor/";

Vue.config.productionTip = false

Vue.use(VueEditor);

new Vue({
  router,
  store,
  VueEditor,
  axios,
  render: h => h(App)
}).$mount('#app')
