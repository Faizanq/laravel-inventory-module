<template>
  <v-container>
    <v-row class="d-flex justify-space-between align-center">
      <h2>Product List</h2>
      <v-btn
        @click="navigateToProductForm"
        color="primary"
        rounded
        >Add Product</v-btn
      >
    </v-row>

    <v-table fixed-header>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">SKU</th>
          <th class="text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in products"
          :key="item.id"
        >
          <td>{{ item.name }}</td>
          <td>{{ item.sku }}</td>
          <td>
            <v-icon @click="viewProduct(item.id)">mdi-eye</v-icon>
          </td>
        </tr>
        <tr v-if="products.length === 0">
          <td
            colspan="3"
            class="text-center"
          >
            No products available
          </td>
        </tr>
      </tbody>
    </v-table>

    <v-pagination
      v-model="currentPage"
      :length="totalPages"
      @input="fetchProducts"
      class="mt-4"
    ></v-pagination>
  </v-container>
</template>

<script setup lang="ts">
import axiosServices from '@/axios'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const products = ref([])
const currentPage = ref(1)
const perPage = 15
const totalRecords = ref(0)
const totalPages = ref(0)

const router = useRouter()

const fetchProducts = async () => {
  try {
    const response = await axiosServices.get('/api/products', {
      params: {
        page: currentPage.value,
      },
    })
    products.value = response.data
    totalRecords.value = response.total
    totalPages.value = Math.ceil(totalRecords.value / perPage)
  } catch (error) {
    console.error('Failed to fetch products:', error)
  }
}

const navigateToProductForm = () => {
  router.push('/products/new')
}

const viewProduct = (id: number) => {
  router.push(`/products/${id}`)
}

onMounted(() => {
  fetchProducts()
})
</script>

<style scoped>
.v-row {
  margin-bottom: 20px;
}
</style>
