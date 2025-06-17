<script setup>
import { faPlus } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Link } from '@inertiajs/vue3'

import { Button } from '@/components/ui/button'
import { useHasPermissions } from '@/composables/hooks/auth/useHasPermissions'

const { hasPermissions } = useHasPermissions()
</script>

<template>
  <Button variant="default" as-child size="sm">
    <Link
      v-if="hasPermissions('company.create')"
      :href="route('admin.company.create')"
    >
      <FontAwesomeIcon :icon="faPlus" class="mr-2" fixed-width />

      <span>Create Company</span></Link
    >
  </Button>
</template>
