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
                v-model="form.email"
                :rules="rules.email"
                label="Email"
                class="my-5"
                required
              ></v-text-field>
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
import { ADD_SUPPLIER_RULES } from '@/validation/rules'
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
      email: '',
    })
    const rules = ADD_SUPPLIER_RULES

    const fetchSupplierDetails = async (id: number) => {
      try {
        const response = await axiosServices.get(`/api/suppliers/${id}`)
        Object.assign(form, response.data)
      } catch (error) {
        console.log('Error fetching supplier details:', error)
      }
    }

    const submit = async () => {
      await nextTick()

      if (formRef.value) {
        const isValid = await formRef.value.validate()

        if (isValid?.valid) {
          try {
            if (form.id) {
              await axiosServices.put(`/api/suppliers/${form.id}`, form)
            } else {
              await axiosServices.post('/api/suppliers', form)
            }
            router.push('/suppliers')
          } catch (error) {
            console.error('Error saving Supplier:', error)
          }
        } else {
          console.log('Form is invalid')
        }
      }
    }

    const cancel = () => {
      router.push('/suppliers')
    }

    onMounted(() => {
      const id = route.params.id as string
      if (id) {
        fetchSupplierDetails(Number(id))
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
