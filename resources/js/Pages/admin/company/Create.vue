<script setup>
import { Head } from '@inertiajs/vue3'

import CompanyForm from '@/components/feature/company/CompanyForm.vue'
import DefaultLayout from '@/components/layout/page/DefaultLayout.vue'
</script>

<template>
  <Head title="Create Company`" />

  <DefaultLayout>
    <div class="">
      <h1 class="text-4xl font-bold">Create Company</h1>

      <p class="">Create a new company</p>

      <section class="mt-8">
        <CompanyForm />
      </section>
    </div>
  </DefaultLayout>
</template>
