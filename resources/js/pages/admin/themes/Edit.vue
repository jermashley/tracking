<script setup>
import { Head, usePage } from '@inertiajs/vue3'

import ThemeForm from '@/components/feature/theme/ThemeForm.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
import { useThemeQuery } from '@/composables/queries/theme'

const { initialTheme } = usePage().props

const { data: theme } = useThemeQuery({
  id: initialTheme.id,

  config: {
    initialData: initialTheme,
  },
})
</script>

<template>
  <Head title="Manage Themes" />

  <AuthenticatedLayout :title="`${theme.name}`">
    <ThemeForm :theme="theme" />
  </AuthenticatedLayout>
</template>
