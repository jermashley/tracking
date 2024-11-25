<script setup>
import { faSignOut, faUser } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { usePage } from '@inertiajs/vue3'

import ThemeToggle from '@/components/feature/theme/ThemeToggle.vue'
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { useLogout } from '@/composables/hooks/auth'

const {
  auth: { user },
  company,
} = usePage().props

const { logout } = useLogout()
</script>

<template>
  <header class="w-full py-2">
    <nav
      class="mx-auto flex h-16 w-full max-w-3xl flex-row items-center justify-between px-6 lg:px-0"
    >
      <div class="flex h-full flex-row items-center justify-start space-x-4">
        <img
          src="/images/company_logos/4-state.png"
          class="h-full w-auto"
          alt="4 State Logo"
        />

        <p class="text-lg font-extrabold text-zinc-700 dark:text-zinc-200">
          {{ company?.name ?? $page.props.app.name }}
        </p>
      </div>

      <div class="flex flex-row items-stretch justify-end space-x-4">
        <!-- <ThemeToggle /> -->

        <div v-if="user" class="w-px bg-zinc-200 p-0 dark:bg-zinc-800" />

        <DropdownMenu v-if="user">
          <DropdownMenuTrigger as-child>
            <Button size="iconSm" variant="outline">
              <FontAwesomeIcon :icon="faUser" fixed-width />
            </Button>
          </DropdownMenuTrigger>

          <DropdownMenuContent align="end" class="w-56">
            <DropdownMenuItem @click="logout">
              <FontAwesomeIcon :icon="faSignOut" fixed-width />

              <span>Log out</span>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
    </nav>
  </header>
</template>
