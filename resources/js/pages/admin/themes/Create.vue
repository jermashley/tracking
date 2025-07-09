<script setup>
import { Head } from '@inertiajs/vue3'

import ThemeForm from '@/components/feature/theme/ThemeForm.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Create a Theme" />

  <AuthenticatedLayout title="Create a Theme">
    <ThemeForm />
  </AuthenticatedLayout>
</template>
