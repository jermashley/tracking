<script setup>
import { Head } from '@inertiajs/vue3'

import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
</script>

<template>
  <Head title="Manage Themes" />

  <AuthenticatedLayout>
    <div>Some themes go here.</div>
  </AuthenticatedLayout>
</template>
