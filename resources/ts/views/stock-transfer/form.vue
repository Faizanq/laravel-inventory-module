<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title class="headline">Add Stock-transfer</v-card-title>
          <v-card-text>
            <v-form
              ref="formRef"
              @submit.prevent="submitForm"
            >
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-text-field
                    v-model="form.date_time"
                    label="Date and Time"
                    type="datetime-local"
                    :rules="[rules.required]"
                    required
                  ></v-text-field>
                </v-col>

                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-select
                    v-model="form.product_id"
                    :items="productList"
                    item-title="name"
                    item-value="id"
                    label="Select Product"
                    :rules="[rules.required]"
                    required
                  ></v-select>
                </v-col>

                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-switch
                    v-model="form.is_from_supplier"
                    label="From Supplier"
                  ></v-switch>
                </v-col>

                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-select
                    v-if="form.is_from_supplier"
                    v-model="form.from_supplier_id"
                    :items="supplierList"
                    item-title="name"
                    item-value="id"
                    label="Select Supplier"
                    :rules="[rules.required]"
                    required
                  ></v-select>
                  <v-select
                    v-else
                    v-model="form.from_warehouse_id"
                    :items="warehouseList"
                    item-title="name"
                    item-value="id"
                    label="Select Warehouse"
                    :rules="[rules.required]"
                    required
                  ></v-select>
                </v-col>

                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-select
                    v-model="form.to_warehouse_id"
                    :items="warehouseList"
                    item-title="name"
                    item-value="id"
                    label="To Warehouse"
                    :rules="[rules.required]"
                    required
                  ></v-select>
                </v-col>

                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-text-field
                    v-model="form.qty"
                    label="Quantity"
                    type="number"
                    :rules="[rules.required]"
                    required
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <div class="button-group">
                    <v-btn
                      @click="submitForm"
                      color="primary"
                      rounded
                      >Submit</v-btn
                    >
                    <v-btn
                      @click="cancel"
                      color="primary"
                      variant="outlined"
                      rounded
                      >Back</v-btn
                    >
                  </div>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { defineComponent, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'

export default defineComponent({
  setup() {
    const router = useRouter()
    const formRef = ref(null)
    const form = reactive({
      date_time: '',
      product_id: null,
      is_from_supplier: false,
      from_supplier_id: null,
      from_warehouse_id: null,
      to_warehouse_id: null,
      qty: 0,
    })
    const productList = reactive([])
    const supplierList = reactive([])
    const warehouseList = reactive([])
    const rules = {
      required: value => !!value || 'Required.',
    }

    const submitForm = async () => {
      await nextTick()
      if (formRef.value) {
        const isValid = await formRef.value.validate()
        if (isValid?.valid) {
          await axiosServices.post('/api/warehouses', form)
          router.push('/stock-transfer')
        } else {
          console.log('Form is invalid')
        }
      }
    }

    const cancel = () => {
      router.push('/stock-transfer')
    }

    const fetchProductList = async () => {
      try {
        const response = await axiosServices.get(`/api/product-list`)
        productList.length = 0
        productList.push(...response.data)
      } catch (error) {
        console.log('Error fetching product list:', error)
      }
    }

    const fetchWarehouseList = async () => {
      try {
        const response = await axiosServices.get(`/api/warehouse-list`)
        warehouseList.length = 0
        warehouseList.push(...response.data)
      } catch (error) {
        console.log('Error fetching warehouse list:', error)
      }
    }
    const fetchSupplierList = async () => {
      try {
        const response = await axiosServices.get(`/api/supplier-list`)
        supplierList.length = 0
        supplierList.push(...response.data)
      } catch (error) {
        console.log('Error fetching supplier list:', error)
      }
    }

    onMounted(() => {
      fetchSupplierList()
      fetchProductList()
      fetchWarehouseList()
    })

    return {
      formRef,
      form,
      productList,
      supplierList,
      warehouseList,
      rules,
      submitForm,
      cancel,
    }
  },
})
</script>
