<script setup>
import ImagesDataTable from '@/components/feature/image/ImagesDataTable.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Manage Images" />

  <AuthenticatedLayout title="Manage Images">
    <ImagesDataTable />
  </AuthenticatedLayout>
</template>
