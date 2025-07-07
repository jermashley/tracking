import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getAllowedDomains = async () => {
  const { data } = await axios.get(route(`api.admin.allowedDomains.index`))

  return data
}

const useAllowedDomainsQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`allowedDomains`],
    queryFn: getAllowedDomains,

    ...config,
  })

export default useAllowedDomainsQuery
