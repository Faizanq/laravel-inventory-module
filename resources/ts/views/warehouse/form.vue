<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title class="headline">Warehouse</v-card-title>
          <v-card-text>
            <v-form
              v-model="valid"
              ref="formRef"
            >
              <v-row>
                <v-col>
                  <v-text-field
                    v-model="form.name"
                    :rules="rules.name"
                    label="Warehouse Name"
                    required
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    v-model="form.location"
                    :rules="rules.location"
                    label="Location"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>

              <h4 class="my-5">Product Stock Detail</h4>

              <v-row
                v-for="(warehouseProduct, index) in warehouseProducts"
                :key="index"
                class="align-center"
                :class="{ 'danger-row': warehouseProduct.available_stock < warehouseProduct.min_stock }"
              >
                <v-col>
                  <v-select
                    v-model="warehouseProduct.product_id"
                    :items="productList"
                    item-title="name"
                    item-value="id"
                    label="Select"
                    persistent-hint
                    single-line
                    readonly
                  ></v-select>
                </v-col>
                <v-col>
                  <v-text-field
                    v-model="warehouseProduct.available_stock"
                    type="number"
                    label="Available Qty"
                  ></v-text-field>
                </v-col>
                <v-col>
                  <v-text-field
                    v-model="warehouseProduct.min_stock"
                    type="number"
                    label="Min Required Qty"
                  ></v-text-field>
                </v-col>
              </v-row>

              <div class="button-group">
                <v-btn
                  @click="submit"
                  color="primary"
                  rounded
                  >Save</v-btn
                >
                <v-btn
                  @click="cancel"
                  color="primary"
                  variant="outlined"
                  rounded
                  >Back</v-btn
                >
              </div>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import axiosServices from '@/axios'
import { ADD_WAREHOUSE_RULES } from '@/validation/rules'
import { defineComponent, nextTick, onMounted, reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default defineComponent({
  name: 'WarehouseDetailForm',
  setup() {
    const route = useRoute()
    const form = reactive({
      id: null,
      name: '',
      location: '',
      stocks: [],
    })
    const rules = ADD_WAREHOUSE_RULES
    const router = useRouter()
    const productList = reactive([])
    const warehouseProducts = reactive([
      {
        product_id: null,
        available_stock: 0,
        min_stock: 0,
      },
    ])
    const formRef = ref(null)

    const fetchWarehouseDetails = async (id: number) => {
      try {
        const response = await axiosServices.get(`/api/warehouses/${id}`)
        form.id = response.data.id
        form.name = response.data.name
        form.location = response.data.location

        response.data.stocks.forEach(stock => {
          const existingProduct = warehouseProducts.find(product => product.product_id === stock.product_id)

          if (existingProduct) {
            existingProduct.available_stock = stock.available_stock
            existingProduct.min_stock = stock.min_stock
          } else {
            warehouseProducts.push({
              product_id: stock.product_id,
              available_stock: stock.available_stock,
              min_stock: stock.min_stock,
            })
          }
        })
      } catch (error) {
        console.log('Error fetching warehouse details:', error)
      }
    }

    const fetchProductList = async () => {
      try {
        const response = await axiosServices.get(`/api/product-list`)
        productList.length = 0
        productList.push(...response.data)
        initializeWarehouseProducts()
      } catch (error) {
        console.log('Error fetching warehouse details:', error)
      }
    }

    const initializeWarehouseProducts = () => {
      warehouseProducts.length = 0
      productList.forEach(product => {
        warehouseProducts.push({
          product_id: product.id,
          available_stock: 0,
          min_stock: 0,
        })
      })
    }

    const submit = async () => {
      await nextTick()

      if (formRef.value) {
        const isValid = await formRef.value.validate()

        if (isValid?.valid) {
          try {
            form.stocks = warehouseProducts
            if (form.id) {
              await axiosServices.put(`/api/warehouses/${form.id}`, form)
            } else {
              await axiosServices.post('/api/warehouses', form)
            }
            router.push('/warehouses')
          } catch (error) {
            console.error('Error saving Warehouse:', error)
          }
        } else {
          console.log('Form is invalid')
        }
      }
    }

    const cancel = () => {
      router.push('/warehouses')
    }

    onMounted(() => {
      fetchProductList()
      const id = route.params.id as string
      if (id) {
        fetchWarehouseDetails(Number(id))
      }
    })

    return {
      formRef,
      rules,
      productList,
      warehouseProducts,
      form,
      submit,
      cancel,
    }
  },
})
</script>
