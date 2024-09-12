<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title class="headline">Product Form</v-card-title>
          <v-card-text>
            <v-form
              v-model="valid"
              ref="formRef"
            >
              <v-row>
                <v-col md="6">
                  <v-text-field
                    v-model="form.name"
                    :rules="rules.name"
                    label="Product Name"
                    required
                  ></v-text-field>
                </v-col>
                <v-col md="6">
                  <v-text-field
                    v-model="form.sku"
                    :rules="rules.sku"
                    label="SKU"
                    required
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
import { ADD_PRODUCT_RULES } from '@/validation/rules'
import { defineComponent, nextTick, reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default defineComponent({
  setup() {
    const route = useRoute()
    const router = useRouter()
    const formRef = ref(null)
    const form = reactive({
      id: null,
      name: '',
      sku: '',
      quantity_in_stock: 0,
    })
    const rules = ADD_PRODUCT_RULES

    const fetchProductDetails = async (id: number) => {
      try {
        const response = await axiosServices.get(`/api/products/${id}`)
        Object.assign(form, response.data)
      } catch (error) {
        console.log('Error fetching product details:', error)
      }
    }

    const submit = async () => {
      await nextTick()

      if (formRef.value) {
        const isValid = await formRef.value.validate()
        if (isValid && isValid.valid) {
          try {
            if (form.id) {
              await axiosServices.put(`/api/products/${form.id}`, form)
            } else {
              await axiosServices.post('/api/products', form)
            }
            router.push('/products')
          } catch (error) {
            console.log('Error saving product:', error)
          }
        } else {
          console.log('Form is invalid')
        }
      }
    }

    const cancel = () => {
      router.push('/products')
    }

    onMounted(() => {
      const id = route.params.id as string
      if (id) {
        fetchProductDetails(Number(id))
      }
    })

    return {
      formRef,
      form,
      rules,
      submit,
      cancel,
    }
  },
})
</script>
