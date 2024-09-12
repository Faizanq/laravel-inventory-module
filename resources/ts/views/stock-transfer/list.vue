<template>
  <v-container>
    <v-row class="d-flex justify-space-between align-center">
      <h2>Deliveries</h2>
      <v-btn
        @click="navigateToStockTransferForm"
        color="primary"
        rounded
        >Add Stock Transfer</v-btn
      >
    </v-row>

    <v-table fixed-header>
      <thead>
        <tr>
          <th class="text-left">Date</th>
          <th class="text-left">Type</th>
          <th class="text-left">Product</th>
          <th class="text-left">Qty</th>
          <th class="text-left">From</th>
          <th class="text-left">To</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in deliveries"
          :key="item.id"
        >
          <td>{{ item.tranfer_date }}</td>
          <td>{{ item.type }}</td>
          <td>{{ item.product }}</td>
          <td>{{ item.quantity }}</td>
          <td>{{ item.from }}</td>
          <td>{{ item.to }}</td>
        </tr>
      </tbody>
    </v-table>
  </v-container>
</template>

<script setup lang="ts">
import axiosServices from '@/axios'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const deliveries = ref([])
const router = useRouter()

const fetchDeliveies = async () => {
  try {
    const response = await axiosServices.get('/api/stock-transfers')
    deliveries.value = response.data
  } catch (error) {
    console.error('Failed to fetch stock ransfer:', error)
  }
}

const navigateToStockTransferForm = () => {
  router.push('/stock-transfer/new')
}

onMounted(() => {
  fetchDeliveies()
})
</script>

<style scoped>
.v-row {
  margin-bottom: 20px;
}
</style>
