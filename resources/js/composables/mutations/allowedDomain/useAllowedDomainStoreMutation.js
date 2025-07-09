import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const storeAllowedDomain = async (formData) => {
  const { data } = await axios.post(
    route(`api.admin.allowedDomains.store`),
    formData,
  )

  return data
}

const useAllowedDomainStoreMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationKey: [`allowedDomain`, `store`],
    mutationFn: ({ formData }) => storeAllowedDomain(formData),

    ...config,
  })

export default useAllowedDomainStoreMutation
