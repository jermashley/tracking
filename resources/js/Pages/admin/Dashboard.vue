<script setup>
import { Head } from '@inertiajs/vue3'

import CompaniesDataTable from '@/components/feature/company/CompaniesDataTable.vue'
import CompanyCreateButton from '@/components/feature/company/CompanyCreateButton.vue'
// import LogoListDialog from '@/components/feature/image/LogoListDialog.vue'
import DefaultLayout from '@/components/layout/page/DefaultLayout.vue'

//
</script>

<template>
  <Head title="Dashboard" />

  <DefaultLayout>
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
  </DefaultLayout>
</template>
