import Vue from 'vue'
import Vuex from 'vuex'

import recipes from './modules/recipes'
import recipe from './modules/recipe'
import user from './modules/user'


Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    loading: false,
    notify: false,
    notifyMSG: null,
    notifyTimeout: 6000,
  },
  getters: {
    LOADING: state => {
      return state.loading
    },
    NOTIFY: state => {
      return state.notify
    },
    NOTIFYMSG: state => {
      return state.notifyMSG
    },
    NOTIFYTIMEOuT: state => {
      return state.notifyTimeout
    }
  },
  mutations: {
    LOAD: (state) => {
      state.loading = !state.loading;
    },
    DO_NOTIFY: (state, msg, timeout) => {
      state.notify = true,
      state.notifyMSG = msg,
      state.timeout = timeout
    },
    DISMISS_NOTIFY: (state) => {
      state.notify = false
    }
  },
  actions: {},

  modules: {
    recipe,
    recipes,
    user
  }

})

export default store