<script setup>
import { faPlus } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Link } from '@inertiajs/vue3'

import { Button } from '@/components/ui/button'
</script>

<template>
  <Button variant="default" as-child size="sm">
    <Link :href="route('admin.company.create')">
      <FontAwesomeIcon :icon="faPlus" class="mr-2" fixed-width />

      <span>Create Company</span></Link
    >
  </Button>
</template>
