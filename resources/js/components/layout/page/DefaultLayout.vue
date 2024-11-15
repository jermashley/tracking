<script setup>
import { faCopyright } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import Navbar from '@/components/layout/navbar/Navbar.vue'
import { Badge } from '@/components/ui/badge'
</script>

<template>
  <div class="grid min-h-screen grid-rows-[1fr,auto] items-center">
    <!-- <Navbar /> -->

    <main class="mx-auto w-full max-w-3xl">
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
