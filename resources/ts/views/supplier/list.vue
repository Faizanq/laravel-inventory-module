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
        <tr v-if="suppliers.length === 0">
          <td
            colspan="3"
            class="text-center"
          >
            No suppliers available
          </td>
        </tr>
      </tbody>
    </v-table>

    <v-pagination
      v-model="currentPage"
      :length="totalPages"
      @input="fetchSuppliers"
      class="mt-4"
    ></v-pagination>
  </v-container>
</template>

<script setup lang="ts">
import axiosServices from '@/axios'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const suppliers = ref([])
const currentPage = ref(1)
const perPage = 15
const totalRecords = ref(0)
const totalPages = ref(0)

const router = useRouter()

const fetchSuppliers = async () => {
  try {
    const response = await axiosServices.get('/api/suppliers', {
      params: {
        page: currentPage.value,
      },
    })
    suppliers.value = response.data
    totalRecords.value = response.total
    totalPages.value = Math.ceil(totalRecords.value / perPage)
  } catch (error) {
    console.error('Failed to fetch suppliers:', error)
  }
}

const navigateToSupplierForm = () => {
  router.push('/suppliers/new')
}

const removeSupplier = async (id: number) => {
  try {
    await axiosServices.delete(`/api/suppliers/${id}`)
    fetchSuppliers() // Refresh the list after deletion
  } catch (error) {
    console.error('Failed to delete supplier:', error)
  }
}

const viewSupplier = (id: number) => {
  router.push(`/suppliers/${id}`)
}

onMounted(() => {
  fetchSuppliers()
})
</script>

<style scoped>
.v-row {
  margin-bottom: 20px;
}

.button-group {
  display: flex;
  gap: 8px;
}
</style>
