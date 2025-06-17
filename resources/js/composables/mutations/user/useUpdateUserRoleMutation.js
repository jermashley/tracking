import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const updateUserRole = async ({ userId, formData }) => {
  const { data } = await axios.put(
    route(`api.users.update.role`, userId),
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
