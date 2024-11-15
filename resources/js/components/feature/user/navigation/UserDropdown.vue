<script setup>
import { faBars, faSignOut } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { router, usePage } from '@inertiajs/vue3'
import axios from 'axios'

import Button from '@/components/ui/button/Button.vue'
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue'
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue'
import DropdownMenuGroup from '@/components/ui/dropdown-menu/DropdownMenuGroup.vue'
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue'
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue'
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue'
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue'

const { user } = usePage().props.auth

const logout = () => {
  axios.post(route(`oauth.logout`)).then(() => router.visit(route(`home`)))
}
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger>
      <Button
        class="flex flex-row items-center justify-center space-x-1"
        variant="outline"
        size="xs"
      >
        <FontAwesomeIcon class="text-sm" :icon="faBars" fixed-width />
      </Button>
    </DropdownMenuTrigger>

    <DropdownMenuContent class="w-64" align="end">
      <DropdownMenuGroup>
        <DropdownMenuLabel class="flex flex-col">
          <span class="text-zinc-700">
            {{ user.first_name ?? `` }} {{ user.last_name ?? `` }}
          </span>

          <span class="text-xs font-medium text-zinc-500">
            {{ user.email }}
          </span>
        </DropdownMenuLabel>

        <DropdownMenuSeparator />

        <DropdownMenuItem @click="logout">
          <FontAwesomeIcon class="mr-2" :icon="faSignOut" fixed-width />

          <span>Sign out</span>
        </DropdownMenuItem>
      </DropdownMenuGroup>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
