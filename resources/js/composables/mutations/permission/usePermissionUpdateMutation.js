import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const updatePermission = async (permissionId, formData) => {
  const { data } = await axios.put(
    route(`api.admin.permissions.update`, permissionId),
    {
      ...formData,
    },
  )

  return data
}

const usePermissionUpdateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id, formData }) => updatePermission(id, formData),

    ...config,
  })

export default usePermissionUpdateMutation
