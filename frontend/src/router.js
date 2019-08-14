import Vue from 'vue'
import Router from 'vue-router'

import loggedOutIndex from '@/components/logged-out/index.vue'

import dashboard from '@/components/logged-in/dashboard/index.vue'

import recipe from '@/components/logged-in/recipe/recipe.vue'
import store from './store';
Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: loggedOutIndex,
      meta: {
        auth: false,
      }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: dashboard,
      meta: {
        auth: true,
      }
    },
    {
      path: '/recipe/:id',
      name: 'recipe',
      component: recipe,
      meta: {
        auth: true,
      }
    }
  ]
})


router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {
    if (store.getters.ISLOGGEDIN) {
      next()
      return
    }
    next('/')
  } else {
    next()
  }
})

export default router