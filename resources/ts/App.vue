<template>
  <VApp>
    <Loader />
    <RouterView />
  </VApp>
</template>

<script setup lang="ts">
import Loader from '@/components/loader.vue'
import { RouterView } from 'vue-router'
import { VApp } from 'vuetify/components'
</script>

<style>
/* Add any global styles here */
</style>
