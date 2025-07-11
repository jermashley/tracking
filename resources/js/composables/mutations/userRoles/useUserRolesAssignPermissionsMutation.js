import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const assignPermissionsToRole = async ({ roleId, permissions }) => {
  const { data } = await axios.put(
    route(`api.admin.roles.assignPermissions`, roleId),
    {
      permissions,
    },
  )
  return data
}

const useUserRolesAssignPermissionsMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ roleId, permissions }) =>
      assignPermissionsToRole({ roleId, permissions }),
    ...config,
  })

export default useUserRolesAssignPermissionsMutation
