<template>
  <v-container>
    <v-row class="d-flex justify-space-between align-center">
      <h2>Supplier List</h2>
      <v-btn
        @click="navigateToSupplierForm"
        color="primary"
        >Add Supplier</v-btn
      >
    </v-row>

    <!-- Using v-table with a fixed header -->
    <v-table fixed-header>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">Email</th>
          <th class="text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in suppliers"
          :key="item.id"
        >
          <td>{{ item.name }}</td>
          <td>{{ item.email }}</td>
          <td>
            <v-btn
              icon
              @click="removeSupplier(index)"
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

// Reactive state for suppliers
const suppliers = ref([])
const router = useRouter()

// Fetch supplier data from API
const fetchsuppliers = async () => {
  try {
    const response = await axiosServices.get('/api/suppliers')
    suppliers.value = response.data
  } catch (error) {
    console.error('Failed to fetch suppliers:', error)
  }
}

// State and methods for dialog management
const navigateToSupplierForm = () => {
  router.push('/suppliers/new')
}

// Remove supplier by index
const removeSupplier = (index: Number) => {
  //   suppliers.value.splice(index, 1)
}

onMounted(() => {
  fetchsuppliers()
})
</script>

<style scoped>
.v-row {
  margin-bottom: 20px;
}
</style>
