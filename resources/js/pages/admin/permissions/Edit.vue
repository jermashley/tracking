<script setup>
// import { faEdit } from '@fortawesome/pro-duotone-svg-icons'

import permissionForm from '@/components/feature/permission/permissionForm.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
import { usePermissionQuery } from '@/composables/queries/permission'

const props = defineProps({
  permissions: {
    type: Object,
    required: true,
  },
})

const { data: permission, isError } = usePermissionQuery({
  id: props.permissions.id,

  config: {
    initialData: props.permissions,
  },
})
</script>

<template>
  <AuthenticatedLayout :title="'Permission Information'">
    <permissionForm v-if="permission && !isError" :permission="permission" />
  </AuthenticatedLayout>
</template>
