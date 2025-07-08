import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const validateCompanyApiToken = async ({ companyId }) => {
  const { data } = await axios.get(
    route(`api.admin.companyApiTokens.validate`, companyId),
  )

  console.log(`validateCompanyApiToken`, data)

  return data
}

const useCompanyApiTokenValidateQuery = ({ companyId, config = {} }) =>
  useQuery({
    queryKey: [`companyApiToken`, companyId, `validate`],
    queryFn: () => validateCompanyApiToken({ companyId }),

    select: (data) => Boolean(data),

    staleTime: 1000 * 60 * 1,
    cacheTime: 1000 * 60 * 5,
    refetchInterval: 1000 * 60 * 1,
    refetchIntervalInBackground: 1000 * 60 * 5,
    refetchOnWindowFocus: true,

    ...config,
  })

export default useCompanyApiTokenValidateQuery
