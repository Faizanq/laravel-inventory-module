<template>
  <v-container>
    <v-row justify="center">
      <v-col
        cols="12"
        sm="8"
        md="4"
      >
        <v-card>
          <v-card-title class="headline">Login</v-card-title>
          <v-card-subtitle>Please enter your credentials to login</v-card-subtitle>

          <v-form
            v-model="valid"
            @submit.prevent="submit"
          >
            <v-card-text>
              <v-text-field
                v-model="form.email"
                :rules="authRules.email"
                label="Email"
                type="email"
                required
              ></v-text-field>

              <v-text-field
                v-model="form.password"
                :rules="authRules.password"
                label="Password"
                type="password"
                required
              ></v-text-field>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                :disabled="!valid"
                color="primary"
                type="submit"
                >Login</v-btn
              >
            </v-card-actions>
          </v-form>

          <v-alert
            v-if="errorMessage"
            type="error"
            class="mt-3"
            >{{ errorMessage }}</v-alert
          >
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import axiosServices from '@/axios'
import { AUTH_RULES } from '@/validation/rules'
import { defineComponent, reactive, ref } from 'vue'
export default defineComponent({
  setup() {
    const valid = ref(false)
    const errorMessage = ref('')
    const form = reactive({
      email: '',
      password: '',
    })

    const authRules = AUTH_RULES

    const submit = async () => {
      if (valid.value) {
        try {
          // Replace with your API request logic
          const response = await axiosServices.post('/api/login', form)
          // Handle successful login (e.g., redirect to dashboard)
          // this.$router.push('/dashboard');
        } catch (error) {
          console.log(error, 'in login')
          errorMessage.value = 'Login failed. Please check your credentials.'
        }
      }
    }

    return {
      valid,
      errorMessage,
      form,
      authRules,
      submit,
    }
  },
})
</script>

<style scoped>
/* Add any styles you need here */
</style>
