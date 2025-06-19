import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const createCompany = async (formData) => {
  const { data } = await axios.post(route(`api.permissions.store`), formData)

  return data
}

const usePermissionCreateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ formData }) => createCompany(formData),

    ...config,
  })

export default usePermissionCreateMutation
