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
              <v-text-field
                v-model="form.name"
                :rules="rules.name"
                label="Warehouse Name"
                required
              ></v-text-field>
              <v-text-field
                v-model="form.location"
                :rules="rules.location"
                label="Location"
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
import { ADD_WAREHOUSE_RULES } from '@/validation/rules'
import { defineComponent, nextTick, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default defineComponent({
  setup() {
    const route = useRoute()
    const form = reactive({
      id: null,
      name: '',
      location: '',
    })
    const rules = ADD_WAREHOUSE_RULES
    const router = useRouter()
    const formRef = ref(null)

    const fetchWarehouseDetails = async (id: number) => {
      try {
        const response = await axiosServices.get(`/api/warehouses/${id}`)
        Object.assign(form, response.data)
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
      const id = route.params.id as string
      if (id) {
        fetchWarehouseDetails(Number(id))
      }
    })

    return {
      formRef,
      rules,
      form,
      submit,
      cancel,
    }
  },
})
</script>
