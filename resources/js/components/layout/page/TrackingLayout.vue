<script setup>
import { faCopyright } from '@fortawesome/pro-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import dayjs from 'dayjs'

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
        <a
          href="https://prologuetechnology.com/"
          target="_blank"
          rel="noopener noreferrer"
          class="font-semibold underline"
        >
          {{ $page.props.app.name }}
        </a>

        <FontAwesomeIcon
          class="mx-[0.125rem] text-xs"
          :icon="faCopyright"
          fixed-width
        />

        {{ dayjs().year() }}
      </p>

      <div
        v-if="$page.props.app.env !== `production`"
        class="flex flex-row items-center justify-center"
      >
        <Badge variant="destructive" class="capitalize">
          <span>{{ $page.props.app.env }}</span>
        </Badge>
      </div>
    </footer>
  </div>
</template>
