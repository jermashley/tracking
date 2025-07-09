import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getRoles = async () => {
  const { data } = await axios.get(route(`api.admin.roles.index`))

  return data
}

const useRolesQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`roles`],
    queryFn: getRoles,
    staleTime: Infinity,

    ...config,
  })

export default useRolesQuery
