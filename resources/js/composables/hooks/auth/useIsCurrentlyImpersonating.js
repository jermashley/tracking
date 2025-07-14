import { usePage } from '@inertiajs/vue3'

const useIsCurrentlyImpersonating = () => {
  const { is_impersonating } = usePage().props

  return {
    isCurrentlyImpersonating: is_impersonating,
  }
}

export default useIsCurrentlyImpersonating
