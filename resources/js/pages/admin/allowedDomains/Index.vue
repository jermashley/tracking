<script setup>
import { Head } from '@inertiajs/vue3'

import AllowedDomainCreateButton from '@/components/feature/allowedDomain/AllowedDomainCreateButton.vue'
import AllowedDomainsDataTable from '@/components/feature/allowedDomain/AllowedDomainsDataTable.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Allowed Domains" />

  <AuthenticatedLayout
    title="Allowed Domains"
    :action="AllowedDomainCreateButton"
  >
    <AllowedDomainsDataTable />
  </AuthenticatedLayout>
</template>
