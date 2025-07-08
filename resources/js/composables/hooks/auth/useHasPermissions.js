import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

export function useHasPermissions() {
  const page = usePage()

  const permissions = computed(() => page.props.auth?.permissions || [])

  const hasPermissions = (permission) => {
    return permissions.value.includes(permission)
  }

  return {
    permissions,
    hasPermissions,
  }
}
