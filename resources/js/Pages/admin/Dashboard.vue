<script setup>
import { Head } from '@inertiajs/vue3'

import CompaniesDataTable from '@/components/feature/company/CompaniesDataTable.vue'
import CompanyCreateButton from '@/components/feature/company/CompanyCreateButton.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div
      class="mb-4 flex flex-col items-stretch justify-start space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0"
    >
      <h2 class="text-2xl font-semibold">Companies</h2>

      <div class="flex flex-row items-center justify-start space-x-2">
        <!-- <LogoListDialog /> -->

        <CompanyCreateButton />
      </div>
    </div>

    <CompaniesDataTable />
  </AuthenticatedLayout>
</template>
