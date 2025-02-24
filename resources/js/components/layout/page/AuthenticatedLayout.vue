<script setup>
import { VueQueryDevtools } from '@tanstack/vue-query-devtools'

import AuthenticatedNavbar from '../navigation/AuthenticatedNavbar.vue'

defineProps({
  title: {
    type: String,
    required: false,
    default: null,
  },
})
</script>

<template>
  <div class="grid min-h-screen grid-rows-[auto,1fr] items-start">
    <AuthenticatedNavbar />

    <main class="mx-auto h-full w-full max-w-3xl px-6 pb-20 pt-12 lg:px-0">
      <h1 v-if="title" class="mb-4 text-2xl font-semibold">{{ title }}</h1>

      <slot />
    </main>
  </div>

  <VueQueryDevtools />
</template>
