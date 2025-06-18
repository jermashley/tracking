<script setup lang="ts">
import { faEllipsisVertical } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { useUpdateUserRoleMutation } from '@/composables/mutations/user'
import { useRolesQuery } from '@/composables/queries/roles'

const { data: roles } = useRolesQuery()
const props = defineProps({
  userId: {
    type: Number,
    required: true,
  },
})

const emit = defineEmits([`role-updated`])

const mutation = useUpdateUserRoleMutation({
  onSuccess: () => {
    console.log(`Role updated`)
    // optional: show toast or refetch
  },
  onError: (error) => {
    console.error(`Failed to update role:`, error)
  },
})

const handleRoleChange = async (role) => {
  try {
    await mutation.mutateAsync({
      userId: props.userId,
      formData: { role: role },
    })
    emit(`role-updated`, role)
  } catch (error) {
    console.error(`Failed to update role`, error)
  }
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
