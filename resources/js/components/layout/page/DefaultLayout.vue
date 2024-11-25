<script setup>
import { Badge } from '@/components/ui/badge'
import { useCompanyTheme } from '@/composables/hooks/theme'

import Navbar from '../navigation/Navbar.vue'

useCompanyTheme()
</script>

<template>
  <div class="grid min-h-screen grid-rows-[auto,1fr,auto] items-start">
    <Navbar />

    <main class="mx-auto my-12 w-full max-w-3xl px-6 lg:px-0">
      <slot />
    </main>

    <footer class="flex flex-col items-center justify-center space-y-2 py-4">
      <p class="text-center text-sm">
        {{ $page.props.app.name }}
      </p>

      <div class="flex flex-row items-center justify-center">
        <Badge
          v-if="$page.props.app.env !== `production`"
          variant="destructive"
          class="capitalize"
        >
          <span>{{ $page.props.app.env }}</span>
        </Badge>
      </div>
    </footer>
  </div>
</template>
