import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const updateUserRole = async ({ userId, formData }) => {
  const { data } = await axios.patch(
    route(`api.admin.users.update.role`, userId),
    formData,
  )
  return data
}

const useUpdateUserRoleMutation = (config = {}) =>
  useMutation({
    mutationFn: updateUserRole,
    ...config,
  })

export default useUpdateUserRoleMutation
