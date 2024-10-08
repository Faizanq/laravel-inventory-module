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
          <th class="text-left">From Supplier</th>
          <th class="text-left">From Warehouse</th>
          <th class="text-left">To Warehouse</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in deliveries"
          :key="item.id"
        >
          <td>{{ formatDateTime(item.transfer_date) }}</td>
          <td>{{ item.type }}</td>
          <td>{{ item.product ? `${item.product.name} [${item.product.sku}]` : '' }}</td>
          <td>{{ item.quantity }}</td>
          <td>{{ item.supplier ? item.supplier.name : '-' }}</td>
          <td>{{ item.from_warehouse ? item.from_warehouse.name : '-' }}</td>
          <td>{{ item.to_warehouse ? item.to_warehouse.name : '' }}</td>
        </tr>
        <tr v-if="deliveries.length === 0">
          <td
            colspan="7"
            class="text-center"
          >
            No deliveries available
          </td>
        </tr>
      </tbody>
    </v-table>

    <v-pagination
      v-model="currentPage"
      :length="totalPages"
      @input="fetchDeliveries"
      class="mt-4"
    ></v-pagination>
  </v-container>
</template>

<script setup lang="ts">
import axiosServices from '@/axios'
import { formatDateTime } from '@/helper'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const deliveries = ref([])
const currentPage = ref(1)
const perPage = 15
const totalRecords = ref(0)
const totalPages = ref(0)

const router = useRouter()

const fetchDeliveries = async () => {
  try {
    const response = await axiosServices.get('/api/stock-transfers', {
      params: {
        page: currentPage.value,
      },
    })
    deliveries.value = response.data
    totalRecords.value = response.total
    totalPages.value = Math.ceil(totalRecords.value / perPage)
  } catch (error) {
    console.error('Failed to fetch stock transfers:', error)
  }
}

const navigateToStockTransferForm = () => {
  router.push('/stock-transfer/new')
}

onMounted(() => {
  fetchDeliveries()
})
</script>

<style scoped>
.v-row {
  margin-bottom: 20px;
}
</style>
