<script setup>
import { usePage } from '@inertiajs/vue3'

import RolePermissionTable from '@/components/feature/role/RolePermissionTable.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'

const { initialRole, allPermissions } = usePage().props
</script>

<template>
  <AuthenticatedLayout>
    <span class="text-2xl font-bold"
      >Edit permissions for: {{ initialRole.name }}</span
    >

    <RolePermissionTable
      class="mt-12"
      :permissions="initialRole.permissions"
      :all-permissions="allPermissions"
    />
  </AuthenticatedLayout>
</template>
