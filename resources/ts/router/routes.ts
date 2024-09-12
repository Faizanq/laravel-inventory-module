import LoginPage from '@/views/auth/Login.vue'
import ProductForm from '@/views/product/form.vue'
import ProductList from '@/views/product/list.vue'
import StockTransferForm from '@/views/stock-transfer/form.vue'
import StockTransferList from '@/views/stock-transfer/list.vue'
import SupplierForm from '@/views/supplier/form.vue'
import SupplierList from '@/views/supplier/list.vue'
import WarehouserForm from '@/views/warehouse/form.vue'
import WarehouserList from '@/views/warehouse/list.vue'
//resources/ts/views/stock-transfer/form.vue
const routes = [
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
      {
        path: 'products/:id',
        component: () => ProductForm,
      },
      {
        path: 'warehouses',
        component: () => WarehouserList,
      },
      {
        path: 'warehouses/new',
        component: () => WarehouserForm,
      },
      {
        path: 'warehouses/:id',
        component: () => WarehouserForm,
      },
      {
        path: 'suppliers',
        component: () => SupplierList,
      },
      {
        path: 'suppliers/new',
        component: () => SupplierForm,
      },
      {
        path: 'suppliers/:id',
        component: () => SupplierForm,
      },
      {
        path: 'stock-transfer',
        component: () => StockTransferList,
      },
      {
        path: 'stock-transfer/new',
        component: () => StockTransferForm,
      },
    ],
  },
]

export default routes
