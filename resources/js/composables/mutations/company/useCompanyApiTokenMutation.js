import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const setCompanyApiToken = async (companyId, apiToken) => {
  console.log({ companyId, apiToken })
  const { data } = await axios.post(route(`api.companyApiTokens.store`), {
    api_token: apiToken,
    company_id: companyId,
  })

  return data
}

const useCompanyApiTokenMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ companyId, apiToken }) =>
      setCompanyApiToken(companyId, apiToken),

    ...config,
  })

export default useCompanyApiTokenMutation
