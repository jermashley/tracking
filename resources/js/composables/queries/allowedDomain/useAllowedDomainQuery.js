import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getAllowedDomain = async (id) => {
  const { data } = await axios.get(route(`admin.allowedDomains.show`, id))

  return data
}

const useAllowedDomainQuery = ({ id, config = {} } = {}) =>
  useQuery({
    queryKey: [`allowedDomain`, id],
    queryFn: () => getAllowedDomain(id),

    ...config,
  })

export default useAllowedDomainQuery
