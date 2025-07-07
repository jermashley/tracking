import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const setCompanyApiToken = async (formData) => {
  console.log({ formData })
  const { data } = await axios.post(
    route(`api.admin.companyApiTokens.store`),
    formData,
  )

  return data
}

const useCompanyApiTokenStoreMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ companyId, apiToken, quoteId }) =>
      setCompanyApiToken({
        company_id: companyId,
        api_token: apiToken,
        quote_id: quoteId,
      }),

    ...config,
  })

export default useCompanyApiTokenStoreMutation
