<script lang="ts" setup>
import { useTheme } from 'vuetify'

import upgradeBannerDark from '@images/pro/upgrade-banner-dark.png'
import upgradeBannerLight from '@images/pro/upgrade-banner-light.png'
import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'

// Components
import Footer from '@/layouts/components/Footer.vue'
import UserProfile from '@/layouts/components/UserProfile.vue'

// Banner

const vuetifyTheme = useTheme()

const upgradeBanner = computed(() => {
  return vuetifyTheme.global.name.value === 'light' ? upgradeBannerLight : upgradeBannerDark
})
</script>

<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <!-- 👉 Vertical nav toggle in overlay mode -->
        <IconBtn
          class="ms-n3 d-lg-none"
          @click="toggleVerticalOverlayNavActive(true)"
        >
          <VIcon icon="mdi-menu" />
        </IconBtn>

        <VSpacer />

        <!-- <NavbarThemeSwitcher class="me-2" /> -->

        <UserProfile />
      </div>
    </template>

    <template #vertical-nav-content>
      <!-- <VerticalNavLink
        :item="{
          title: 'Dashboard',
          icon: 'mdi-home-outline',
          to: '/dashboard',
        }"
      /> -->

      <!-- Menu -->
      <!-- <VerticalNavSectionTitle
        :item="{
          heading: 'Dashboard',
        }"
      /> -->
      <VerticalNavLink
        :item="{
          title: 'Products',
          icon: 'mdi-package-variant',
          to: '/products',
        }"
      />

      <VerticalNavLink
        :item="{
          title: 'Warehouses',
          icon: 'mdi-warehouse',
          to: '/warehouses',
        }"
      />

      <VerticalNavLink
        :item="{
          title: 'Supplier',
          icon: 'mdi-store',
          to: '/suppliers',
        }"
      />

      <VerticalNavLink
        :item="{
          title: 'Stock Transfer',
          icon: 'mdi-exchange',
          to: '/stock-transfer',
        }"
      />
    </template>

    <slot />

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>
  </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}
</style>
