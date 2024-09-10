<!-- components/Loader.vue -->
<template>
  <div
    v-if="isLoading"
    class="loader-overlay"
  >
    <div class="loader">
      <v-progress-circular
        indeterminate
        color="primary"
      ></v-progress-circular>
    </div>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent } from 'vue'

export default defineComponent({
  setup() {
    const isLoading = computed(() => localStorage.getItem('loading') === 'true')

    return {
      isLoading,
    }
  },
})
</script>

<style scoped>
.loader-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.loader {
  background: white;
  padding: 20px;
  border-radius: 8px;
}
</style>
