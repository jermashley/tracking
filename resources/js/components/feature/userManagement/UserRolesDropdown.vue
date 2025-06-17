<script setup lang="ts">
import { faEllipsisVertical } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { ref } from 'vue'

import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

const roles = ref([
  { name: `Admin`, value: `admin` },
  { name: `User`, value: `user` },
  { name: `Guest`, value: `guest` },
]) // TODO this needs to hit the api from a composable that MM is creating

const handleRoleChange = (role) => {
  console.log(`Selected role: ${role.name}`)
}
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger>
      <FontAwesomeIcon class="mr-2" :icon="faEllipsisVertical" fixed-width />
    </DropdownMenuTrigger>
    <DropdownMenuContent>
      <DropdownMenuLabel>Roles</DropdownMenuLabel>
      <DropdownMenuSeparator />
      <DropdownMenuItem
        v-for="role in roles"
        :key="role.value"
        @click="() => handleRoleChange(role)"
      >
        {{ role.name }}
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
