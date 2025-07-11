import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const setCompanyApiToken = async (formData) => {
  const { data } = await axios.post(
    route(`api.admin.companyApiTokens.store`),
    formData,
  )

  return data
}

const useCompanyApiTokenStoreMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ companyId, apiToken, trackingNumber }) =>
      setCompanyApiToken({
        company_id: companyId,
        api_token: apiToken,
        trackingNumber: trackingNumber,
      }),

    ...config,
  })

export default useCompanyApiTokenStoreMutation
