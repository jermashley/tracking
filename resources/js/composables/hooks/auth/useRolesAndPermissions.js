import { usePage } from '@inertiajs/vue3'

import { useUserQuery } from '@/composables/queries/user'

const useRolesAndPermissions = () => {
  const { user: initialUser } = usePage().props.auth

  const { data: user } = useUserQuery({
    userId: initialUser.id,

    config: {
      initialData: initialUser,
    },
  })

  const userIs = (role) => {
    return user.value.roles.some((r) => r.name === role)
  }

  const userCan = (permission) => {
    return user.value.roles[0].permissions.some((p) => p.name === permission)
  }

  const userCannot = (permission) => {
    return !user.value.roles[0].permissions.some((p) => p.name === permission)
  }

  return { userIs, userCan, userCannot }
}

export default useRolesAndPermissions
