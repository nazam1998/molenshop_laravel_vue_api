import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import store from '../store';

Vue.use(VueRouter)

const routes = [{
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/shops/',
    name: 'Shops',
    component: () => import( /* webpackChunkName: "shop"*/ '../views/Shops.vue'),
    props: true,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/shop/:shopid',
    name: 'Shop',
    component: () => import( /* webpackChunkName: "shop"*/ '../views/Shop.vue'),
    props: true,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/profil',
    name: 'Profil',
    component: () => import( /* webpackChunkName: "profil" */ '../views/Profil.vue'),
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/myshop',
    name: 'MyShop',
    component: () => import( /* webpackChunkName: "myshop" */ '../views/MyShop.vue'),
    meta: {
      requiresAuth: true
    }
  }, {
    path: '/product/:productid',
    name: 'Product',
    component: () => import( /* webpackChunkName: "product", */ '../views/Product.vue'),
    props: true,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/myorders',
    name: 'MyOrders',
    component: () => import( /* webpackChunkName: "myorders" */ '../views/MyOrders.vue'),
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/order/:orderid',
    name: 'Order',
    component: () => import( /* webpackChunkName: "order", */ '../views/Order.vue'),
    props: true,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/mycart',
    name: 'Panier',
    component: () => import( /* webpackChunkName: "mycart" */ '../views/Panier.vue'),
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import( /* webpackChunkName: "login" */ '../views/Login.vue'),
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import( /* webpackChunkName: "register" */ '../views/Register.vue'),
    meta: {
      requiresGuest: true
    }
  },

]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.state.auth_token) {
      next({
        name: 'Login',
      });
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.requiresGuest)) {
    if (store.state.auth_token) {
      return next({
        name: 'Home'
      })
    } else {
      next()
    }
  } else {
    next()
  }
})
export default router