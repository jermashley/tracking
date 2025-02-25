import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getCompanies = async () => {
  const { data } = await axios.get(route(`api.companies.index`))

  return data
}

const useCompaniesQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`companies`],
    queryFn: getCompanies,
    staleTime: Infinity,
    cacheTime: Infinity,

    ...config,
  })

export default useCompaniesQuery
