<script setup>
import { Head } from '@inertiajs/vue3'

import PermissionsDataTable from '@/components/feature/permission/PermissionsDataTable.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Tracking" />

  <AuthenticatedLayout>
    <PermissionsDataTable />
  </AuthenticatedLayout>
</template>
