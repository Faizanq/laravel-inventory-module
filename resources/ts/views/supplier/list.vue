<template>
  <v-container>
    <v-row class="d-flex justify-space-between align-center">
      <h2>Supplier List</h2>
      <v-btn
        @click="navigateToSupplierForm"
        color="primary"
        rounded
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
            <div class="button-group">
              <v-icon @click="viewSupplier(item.id)">mdi-eye</v-icon>
              <v-icon @click="removeSupplier(item.id)">mdi-delete</v-icon>
            </div>
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

const suppliers = ref([])
const router = useRouter()

const fetchsuppliers = async () => {
  try {
    const response = await axiosServices.get('/api/suppliers')
    suppliers.value = response.data
  } catch (error) {
    console.error('Failed to fetch suppliers:', error)
  }
}

const navigateToSupplierForm = () => {
  router.push('/suppliers/new')
}

const removeSupplier = async (id: Number) => {
  try {
    await axiosServices.delete(`/api/suppliers/${id}`)
    fetchsuppliers()
  } catch (error) {
    console.error('Failed to delete suppliers:', error)
  }
}

const viewSupplier = (id: number) => {
  router.push(`/suppliers/${id}`)
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
