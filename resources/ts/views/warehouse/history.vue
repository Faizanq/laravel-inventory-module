<template>
  <v-container>
    <v-row class="d-flex justify-space-between align-center">
      <h2>Stock History</h2>
      <v-btn
        @click="navigateToWarehouseList"
        color="primary"
        rounded
      >
        Back
      </v-btn>
    </v-row>

    <v-table fixed-header>
      <thead>
        <tr>
          <th>Date</th>
          <th>Product</th>
          <th>Qty</th>
          <th>Type</th>
          <th>Supplier</th>
          <th>From Warehosue</th>
          <th>To Warehosue</th>
          <th>Remaining Qty</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, index) in history"
          :key="item.id"
        >
          <td>{{ item.transfer_date ? item.transfer_date : item?.stock_transfer.transfer_date }}</td>
          <td>{{ item?.product.name || '-' }}</td>
          <td>{{ item?.quantity_change }}</td>
          <td>{{ item?.type }}</td>
          <td>{{ item?.stock_transfer?.from_supplier_id ? item?.stock_transfer?.supplier?.name || '-' : '-' }}</td>
          <td>
            {{
              item?.warehouse_id != item?.stock_transfer?.from_warehouse_id
                ? item?.stock_transfer?.from_warehouse?.name || '-'
                : '-'
            }}
          </td>
          <td>
            {{
              item?.warehouse_id != item?.stock_transfer?.to_warehouse_id
                ? item?.stock_transfer?.to_warehouse?.name || '-'
                : '-'
            }}
          </td>
          <td>{{ item?.quantity || '-' }}</td>
        </tr>
        <tr v-if="!history">
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
import { useRoute, useRouter } from 'vue-router'

const history = ref([])
const currentPage = ref(1)
const perPage = ref(15)
const totalRecords = ref(0)
const totalPages = ref(0)
const route = useRoute()
const router = useRouter()

const fetchWarehousHistory = async () => {
  try {
    const warehouseId = route.params.id as string
    const response = await axiosServices.get('/api/warehouse/stock-transfers', {
      params: {
        warehouse_id: warehouseId,
        page: currentPage.value,
      },
    })

    history.value = response.data
    totalRecords.value = response.total
    totalPages.value = Math.ceil(totalRecords.value / perPage.value)
  } catch (error) {
    console.error('Failed to fetch warehouses:', error)
  }
}

const navigateToWarehouseList = () => {
  router.push('/warehouses')
}

onMounted(() => {
  fetchWarehousHistory()
})
</script>

<style scoped>
.v-row {
  margin-bottom: 20px;
}
</style>
