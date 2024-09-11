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
              <v-text-field
                v-model="form.name"
                :rules="rules.name"
                label="Product Name"
                required
              ></v-text-field>
              <v-text-field
                v-model="form.sku"
                :rules="rules.sku"
                label="SKU"
                required
              ></v-text-field>
              <v-text-field
                v-model="form.quantity_in_stock"
                :rules="rules.quantity_in_stock"
                label="Quantity in Stock"
                type="number"
                required
              ></v-text-field>
              <v-btn
                @click="submit"
                color="primary"
                >Save Product</v-btn
              >
              <v-btn
                @click="cancel"
                color="secondary"
                >Cancel</v-btn
              >
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
import { useRouter } from 'vue-router'

export default defineComponent({
  setup() {
    const router = useRouter()
    const formRef = ref(null) // Assuming you have a form ref
    const form = reactive({
      name: '',
      price: 0,
      // Add other form fields
    })
    const rules = ADD_PRODUCT_RULES
    const submit = async () => {
      await nextTick()

      if (formRef.value) {
        const isValid = await formRef.value.validate()
        debugger
        if (isValid && isValid.valid) {
          try {
            const response = await axiosServices.post('/api/products', form)
            console.log('Product saved:', response.data)
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
