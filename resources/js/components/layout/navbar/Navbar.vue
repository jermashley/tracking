<script setup>
import { usePage } from '@inertiajs/vue3'

import UserDropdown from '@/components/feature/user/navigation/UserDropdown.vue'
import Badge from '@/components/ui/badge/Badge.vue'

const { user } = usePage().props.auth
</script>

<template>
  <div class="w-full">
    <nav
      class="mx-auto flex max-w-3xl flex-row items-center justify-between py-4"
    >
      <div class="flex flex-row items-center justify-start space-x-2">
        <span class="text-sm font-bold uppercase text-zinc-600">
          {{ $page.props.app.name }}
        </span>

        <Badge
          v-if="$page.props.app.env !== `production`"
          variant="outline"
          class="capitalize"
        >
          {{ $page.props.app.env }}
        </Badge>
      </div>

      <div class="flex flex-row items-center justify-end space-x-2">
        <UserDropdown v-if="user" />
      </div>
    </nav>
  </div>
</template>
