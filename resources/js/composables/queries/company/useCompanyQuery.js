import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getCompany = async (id) => {
  const { data } = await axios.get(route(`api.companies.show`, id))

  return data
}

const useCompanyQuery = ({ config = {}, id = null } = {}) =>
  useQuery({
    queryKey: [`companies`, id],
    queryFn: () => getCompany(id),
    staleTime: Infinity,

    ...config,
  })

export default useCompanyQuery
