import { router } from '@inertiajs/vue3'
import axios from 'axios'

export const useLogout = () => {
  const logout = () =>
    axios.post(route(`oauth.logout`)).then(() => router.visit(route(`login`)))

  return {
    logout,
  }
}
