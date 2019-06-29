import Vue from 'vue'
import Router from 'vue-router'

import loggedOutIndex from '@/components/logged-out/index.vue'

import dashboard from '@/components/logged-in/dashboard/index.vue'

import recipe from '@/components/logged-in/recipe/recipe.vue'
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: loggedOutIndex
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: dashboard
    },
    {
      path: '/recipe',
      name: 'recipe',
      component: recipe
    }
  ]
})
