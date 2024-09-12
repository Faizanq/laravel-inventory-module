<template>
  <v-container>
    <v-row class="d-flex justify-space-between align-center">
      <h2>Warehouse List</h2>
      <v-btn
        @click="navigateToProductForm"
        color="primary"
        rounded
      >
        Add Warehouse
      </v-btn>
    </v-row>

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
            <div class="button-group">
              <v-icon @click="viewWarehouse(item.id)">mdi-eye</v-icon>
              <v-icon @click="viewStockHistory(item.id)">mdi-history</v-icon>
            </div>
          </td>
        </tr>
        <tr v-if="!warehouses">
          <td
            colspan="3"
            class="text-center"
          >
            No warehouses available
          </td>
        </tr>
      </tbody>
    </v-table>
    <v-pagination
      v-model="currentPage"
      :length="totalPages"
      :total-visible="5"
      @input="fetchWarehouses"
      class="mt-4"
      rounded="circle"
    ></v-pagination>
  </v-container>
</template>

<script setup lang="ts">
import axiosServices from '@/axios'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const warehouses = ref([])
const currentPage = ref(1)
const perPage = ref(15)
const totalRecords = ref(0)
const totalPages = ref(0)

const router = useRouter()

const fetchWarehouses = async () => {
  try {
    const response = await axiosServices.get('/api/warehouses', {
      params: {
        page: currentPage.value,
      },
    })

    warehouses.value = response.data
    totalRecords.value = response.total
    totalPages.value = Math.ceil(totalRecords.value / perPage.value)
  } catch (error) {
    console.error('Failed to fetch warehouses:', error)
  }
}

const navigateToProductForm = () => {
  router.push('/warehouses/new')
}

const viewWarehouse = (id: number) => {
  router.push(`/warehouses/${id}`)
}

const viewStockHistory = (id: number) => {
  router.push(`/warehouses/stock-transfer/${id}`)
}

onMounted(() => {
  fetchWarehouses()
})
</script>

<style scoped>
.v-row {
  margin-bottom: 20px;
}
</style>
