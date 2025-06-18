<script setup>
import { Head } from '@inertiajs/vue3'

import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
import RoleTable from "@/components/feature/role/RoleTable.vue";
</script>

<template>
  <Head title="Tracking" />

  <AuthenticatedLayout title="Manage Roles">
    <RoleTable />
  </AuthenticatedLayout>
</template>
