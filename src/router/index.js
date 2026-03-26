import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import(/* webpackChunkName: "about" */ '../views/contact.vue')
  },
  {
    path: '/product_api',
    name: 'product_api',
    component: () => import(/* webpackChunkName: "about" */ '../views/Product_api.vue')
  },
  {
    path: '/product_list',
    name: 'product_list',
    component: () => import(/* webpackChunkName: "about" */ '../views/product_list.vue')
  },
  {
    path: '/gold',
    name: 'gold',
    component: () => import(/* webpackChunkName: "about" */ '../views/gold.vue')
  },
  {
    path: '/show_customer',
    name: 'show_customer',
    component: () => import(/* webpackChunkName: "about" */ '../views/show_customer.vue')
  },
  {
    path: '/show_employees',
    name: 'show_employees',
    component: () => import(/* webpackChunkName: "about" */ '../views/show_Employees.vue')
  },
    {
    path: '/Register',
    name: 'Register',
    component: () => import(/* webpackChunkName: "about" */ '../views/Register.vue')
  },
  {
    path: '/add_employee',
    name: 'add_employee',
    component: () => import(/* webpackChunkName: "about" */ '../views/addemployees.vue')
  },
] 


const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router