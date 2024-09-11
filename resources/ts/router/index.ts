import LoginPage from '@/views/auth/Login.vue'
import ProductList from '@/views/product/list.vue'
import ProductForm from '@/views/product/form.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/login',
      component: () => import('../layouts/blank.vue'),
      children: [
        {
          path: 'login',
          component: () => LoginPage,
        },
        {
          path: '/:pathMatch(.*)*',
          component: () => import('../pages/[...all].vue'),
        },
      ],
    },
    {
      path: '/',
      component: () => import('../layouts/default.vue'),
      children: [
        {
          path: 'dashboard',
          component: () => import('../pages/dashboard.vue'),
        },
        {
          path: 'products',
          component: () => ProductList,
        },
        {
          path: 'products/new',
          component: () => ProductForm,
        },
      ],
    },
  ],
})

export default router
