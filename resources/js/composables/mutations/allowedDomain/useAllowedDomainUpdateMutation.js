import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const updateAllowedDomain = async (id, formData) => {
  const { data } = await axios.put(
    route(`api.admin.allowedDomains.update`, id),
    formData,
  )

  return data
}

const useAllowedDomainUpdateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationKey: [`allowedDomain`, `update`],
    mutationFn: ({ id, formData }) => updateAllowedDomain(id, formData),

    ...config,
  })

export default useAllowedDomainUpdateMutation
