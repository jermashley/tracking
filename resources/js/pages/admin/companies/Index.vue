<script setup>
import { Head } from '@inertiajs/vue3'

import CompaniesDataTable from '@/components/feature/company/CompaniesDataTable.vue'
import CompanyCreateButton from '@/components/feature/company/CompanyCreateButton.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Companies" />

  <AuthenticatedLayout title="Companies" :action="CompanyCreateButton">
    <CompaniesDataTable />
  </AuthenticatedLayout>
</template>
