<script setup>
import { faPlus } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Link } from '@inertiajs/vue3'

import { Button } from '@/components/ui/button'
import { useRolesAndPermissions } from '@/composables/hooks/auth'

const { userCan } = useRolesAndPermissions()
</script>

<template>
  <Button variant="default" as-child size="sm">
    <Link v-if="userCan(`role:create`)" :href="route('admin.role.create')">
      <FontAwesomeIcon :icon="faPlus" class="mr-2" fixed-width />

      <span>Create Role</span></Link
    >
  </Button>
</template>
