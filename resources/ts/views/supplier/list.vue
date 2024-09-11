<template>
  <v-container>
    <v-row class="d-flex justify-space-between align-center">
      <h2>Product List</h2>
      <v-btn
        @click="navigateToProductForm"
        color="primary"
        >Add Product</v-btn
      >
    </v-row>

    <!-- Using v-table with a fixed header -->
    <v-table fixed-header>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">Qty</th>
          <th class="text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in products"
          :key="item.id"
        >
          <td>{{ item.name }}</td>
          <td>{{ item.qty }}</td>
          <td>
            <v-btn
              icon
              @click="removeProduct(index)"
            >
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
  </v-container>
</template>

<script setup lang="ts">
import axiosServices from '@/axios'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

// Reactive state for products
const products = ref([])
const router = useRouter()

// Fetch product data from API
const fetchProducts = async () => {
  try {
    const response = await axiosServices.get('/api/products')
    products.value = response.data
  } catch (error) {
    console.error('Failed to fetch products:', error)
  }
}

// State and methods for dialog management
const navigateToProductForm = () => {
  router.push('/products/new')
}

// Remove product by index
const removeProduct = (index: Number) => {
  //   products.value.splice(index, 1)
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
