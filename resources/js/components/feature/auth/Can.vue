<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  permission: {
    type: String,
    required: true,
  },
  role: {
    type: String,
    default: `default`,
  },
})

const page = usePage()
const permissions = page.props.auth.permissions
const roles = page.props.auth.roles

const hasAccess = computed(() => {
  return (
    (props.permission && permissions.includes(props.permission)) ||
    (props.role && roles.includes(props.role))
  )
})
</script>

<template>
  <slot v-if="hasAccess"></slot>
</template>
