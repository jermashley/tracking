import { router } from '@inertiajs/vue3'

export const useLogout = () => {
  const logout = () => router.post(route(`oauth.logout`))

  return {
    logout,
  }
}
