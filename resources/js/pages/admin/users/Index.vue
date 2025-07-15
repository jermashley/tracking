<script setup>
import { Head } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import { onMounted } from 'vue'

import UserManagementTable from '@/components/feature/userManagement/UserManagementTable.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'

const { props } = usePage()

onMounted(() => {
  if (props.reload) {
    window.location.reload()
  }
})
</script>

<template>
  <Head title="Admin | Users" />

  <AuthenticatedLayout title="Users">
    <UserManagementTable />
  </AuthenticatedLayout>
</template>
