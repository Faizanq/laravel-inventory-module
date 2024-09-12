<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title class="headline">Warehouse Form</v-card-title>
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
              <v-row>
                <v-col md="12">
                  <h4>Product Stock Detail</h4>
                </v-col>

                <v-col md="12">
                  <v-row v-for="(product, index) in productList">
                    <v-col>
                      <v-text-field
                        v-model="warehouseProducts[index].product_id"
                        type="hidden"
                        read-only
                      ></v-text-field>
                      <v-text-field
                        :value="`${product.name} [${product.sku}]`"
                        type="text"
                        label="Product"
                        read-only
                      ></v-text-field>
                    </v-col>
                    <v-col>
                      <v-text-field
                        v-model="warehouseProducts[index].product_id"
                        type="number"
                        label="Availible Qty"
                      ></v-text-field>
                    </v-col>
                    <v-col>
                      <v-text-field
                        v-model="warehouseProducts[index].product_id"
                        type="number"
                        label="Min Required Qty"
                      ></v-text-field>
                    </v-col>
                  </v-row>
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
import { defineComponent, nextTick, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default defineComponent({
  name: 'WarehouseDetailForm',
  setup() {
    const route = useRoute()
    const form = reactive({
      id: null,
      name: '',
      location: '',
    })
    const rules = ADD_WAREHOUSE_RULES
    const router = useRouter()
    const productList = reactive([])
    const warehouseProducts = reactive([])
    const formRef = ref(null)

    const fetchWarehouseDetails = async (id: number) => {
      try {
        const response = await axiosServices.get(`/api/warehouses/${id}`)
        Object.assign(form, response.data)
      } catch (error) {
        console.log('Error fetching warehouse details:', error)
      }
    }

    const fetchProductList = async () => {
      try {
        const response = await axiosServices.get(`/api/product-list`)
        productList.length = 0
        productList.push(...response.data)
        console.log(response, 'response')
      } catch (error) {
        console.log('Error fetching warehouse details:', error)
      }
    }

    const submit = async () => {
      await nextTick()

      if (formRef.value) {
        const isValid = await formRef.value.validate()

        if (isValid?.valid) {
          try {
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
