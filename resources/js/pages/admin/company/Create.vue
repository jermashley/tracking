<script setup>
import { Head } from '@inertiajs/vue3'

import CompanyForm from '@/components/feature/company/CompanyForm.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Create Company`" />

  <AuthenticatedLayout title="Create Company">
    <CompanyForm />
  </AuthenticatedLayout>
</template>
