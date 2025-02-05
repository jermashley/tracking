<script setup>
import { Badge } from '@/components/ui/badge'

import Navbar from '../navigation/Navbar.vue'

defineProps({
  hasNavbar: {
    type: Boolean,
    required: false,
    default: true,
  },
})
</script>

<template>
  <div
    class="grid min-h-screen items-start"
    :class="{
      'grid-rows-[auto,1fr,auto]': hasNavbar,
      'grid-rows-[1fr,auto]': !hasNavbar,
    }"
  >
    <Navbar
      v-if="hasNavbar"
      :use-logo="false"
      user-dropdown
      :use-app-name="true"
    />

    <main class="mx-auto mb-20 mt-12 h-full w-full max-w-3xl px-6 lg:px-0">
      <slot />
    </main>
  </div>
</template>
