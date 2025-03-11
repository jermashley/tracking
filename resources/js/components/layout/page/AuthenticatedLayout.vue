<script setup>
import { VueQueryDevtools } from '@tanstack/vue-query-devtools'

import { Toaster } from '@/components/ui/toast'

import AuthenticatedNavbar from '../navigation/AuthenticatedNavbar.vue'

defineProps({
  title: {
    type: String,
    required: false,
    default: null,
  },
  action: {
    type: Function,
    required: false,
    default: () => null,
  },
})
</script>

<template>
  <Toaster />

  <div class="grid min-h-screen grid-rows-[auto,1fr] items-start">
    <AuthenticatedNavbar />

    <main class="mx-auto h-full w-full max-w-3xl px-6 pb-20 pt-12 lg:px-0">
      <div
        class="mb-4 flex flex-col items-stretch justify-start space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0"
      >
        <h1 v-if="title" class="mb-4 text-2xl font-semibold">{{ title }}</h1>

        <action v-if="action" />
      </div>

      <slot />
    </main>
  </div>

  <VueQueryDevtools />
</template>
