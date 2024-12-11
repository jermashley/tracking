<script setup>
import { usePage } from '@inertiajs/vue3'

import UserDropdown from '@/components/feature/user/navigation/UserDropdown.vue'
import { Badge } from '@/components/ui/badge'

const {
  auth: { user },
  company,
} = usePage().props
</script>

<template>
  <header class="w-full py-2">
    <nav
      class="mx-auto flex h-16 w-full max-w-3xl flex-row items-center justify-between px-6 lg:px-0"
    >
      <div class="flex h-full flex-row items-center justify-start space-x-4">
        <img
          v-if="company && company?.logo"
          :src="company.logo.file_path"
          class="h-full w-auto py-4"
          :alt="company.logo?.name ?? `Company logo`"
        />
      </div>

      <div class="flex flex-row items-center justify-end space-x-4">
        <p class="text-lg font-extrabold text-zinc-700 dark:text-zinc-200">
          {{ company?.name ?? $page.props.app.name }}
        </p>

        <Badge variant="destructive" class="text-xs capitalize">
          <span>{{ $page.props.app.env }}</span>
        </Badge>

        <UserDropdown v-if="user" />
      </div>
    </nav>
  </header>
</template>
