import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getCompany = async (id) => {
  const { data } = await axios.get(route(`api.companies.show`, id))

  return data
}

const useCompaniesQuery = ({ config = {}, id = null } = {}) =>
  useQuery({
    queryKey: [`companies`, id],
    queryFn: getCompany,
    staleTime: Infinity,
    cacheTime: Infinity,

    ...config,
  })

export default useCompaniesQuery
