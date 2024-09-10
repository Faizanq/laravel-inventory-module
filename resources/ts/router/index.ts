import LoginPage from '@/views/auth/Login.vue' // Adjust the path as needed
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
          path: 'typography',
          component: () => import('../pages/typography.vue'),
        },
      ],
    },
  ],
})

export default router
