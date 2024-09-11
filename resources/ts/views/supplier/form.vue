<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title class="headline">Supplier Form</v-card-title>
          <v-card-text>
            <v-form
              v-model="valid"
              ref="formRef"
            >
              <v-text-field
                v-model="form.name"
                :rules="rules.name"
                label="Supplier Name"
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
                >Save Supplier</v-btn
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
import { ADD_SUPPLIER_RULES } from '@/validation/rules'
import { defineComponent, nextTick, ref } from 'vue'
import { useRouter } from 'vue-router'

export default defineComponent({
  data() {
    return {
      valid: false,
      form: {
        name: '',
        sku: '',
        quantity_in_stock: 0,
      },
      rules: ADD_SUPPLIER_RULES,
    }
  },
  setup() {
    const router = useRouter()
    const formRef = ref(null)

    const submit = async () => {
      await nextTick()

      if (formRef.value) {
        const isValid = await formRef.value.validate()

        if (isValid) {
          try {
            const response = await axiosServices.post('/api/Suppliers', formRef.value.form)
            console.log('Supplier saved:', response.data)
            router.push('/Suppliers')
          } catch (error) {
            console.error('Error saving Supplier:', error)
          }
        } else {
          console.log('Form is invalid')
        }
      }
    }

    const cancel = () => {
      router.push('/Suppliers')
    }

    return {
      formRef,
      submit,
      cancel,
    }
  },
})
</script>
