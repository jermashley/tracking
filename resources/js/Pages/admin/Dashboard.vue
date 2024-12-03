<script setup>
import { Head } from '@inertiajs/vue3'

import CompaniesDataTable from '@/components/feature/company/CompaniesDataTable.vue'
import DefaultLayout from '@/components/layout/page/DefaultLayout.vue'

//
</script>

<template>
  <Head title="Dashboard" />
  <DefaultLayout>
    <CompaniesDataTable />
  </DefaultLayout>
</template>
