<script setup>
import { Head } from '@inertiajs/vue3'

import CompanyForm from '@/components/feature/company/CompanyForm.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Create Company`" />

  <AuthenticatedLayout title="Create Company">
    <div class="">
      <h1 class="text-4xl font-bold">Create Company</h1>

      <p class="">Create a new company</p>

      <section class="mt-8">
        <CompanyForm />
      </section>
    </div>
  </AuthenticatedLayout>
</template>
