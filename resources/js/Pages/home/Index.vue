<script setup>
import { Head } from '@inertiajs/vue3'

import LoginButton from '@/components/feature/auth/LoginButton.vue'
import DefaultLayout from '@/components/layout/page/DefaultLayout.vue'
</script>

<template>
  <Head title="Home" />

  <DefaultLayout>
    <div
      class="flex min-h-full flex-col items-center justify-center space-y-24"
    >
      <div>
        <h1 class="w-auto text-4xl font-bold text-zinc-700">
          {{ $page.props.app.name }}
        </h1>

        <p class="mt-2 w-auto text-center text-zinc-500">
          Your on-prem tool for shipment tracking.
        </p>
      </div>

      <LoginButton provider="azure" size="lg" />
    </div>
  </DefaultLayout>
</template>
