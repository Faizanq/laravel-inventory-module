<template>
  <v-container>
    <v-row class="d-flex justify-space-between align-center">
      <h2>Warehouse List</h2>
      <v-btn
        @click="navigateToProductForm"
        color="primary"
        rounded
        >Add Warehouse</v-btn
      >
    </v-row>

    <!-- Using v-table with a fixed header -->
    <v-table fixed-header>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">Location</th>
          <th class="text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in warehouses"
          :key="item.id"
        >
          <td>{{ item.name }}</td>
          <td>{{ item.location }}</td>
          <td>
            <v-icon @click="viewWarehosue(item.id)">mdi-eye</v-icon>
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

const warehouses = ref([])
const router = useRouter()

const fetchwarehouses = async () => {
  try {
    const response = await axiosServices.get('/api/warehouses')
    warehouses.value = response.data
  } catch (error) {
    console.error('Failed to fetch warehouses:', error)
  }
}

const navigateToProductForm = () => {
  router.push('/warehouses/new')
}

const viewWarehosue = (id: number) => {
  router.push(`/warehouses/${id}`)
}

onMounted(() => {
  fetchwarehouses()
})
</script>

<style scoped>
.v-row {
  margin-bottom: 20px;
}
</style>
