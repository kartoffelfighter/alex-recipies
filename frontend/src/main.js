import Vue from 'vue'
import App from './App.vue'

import './plugins/vuetify'
import 'roboto-fontface/css/roboto/roboto-fontface.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import router from './router'
import store from './store/'


import VueEditor from "vue2-editor/";

Vue.config.productionTip = true

Vue.use(VueEditor);

new Vue({
  router,
  store,
  VueEditor,

  render: h => h(App)
}).$mount('#app')
