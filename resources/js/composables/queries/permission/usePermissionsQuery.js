import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getPermissions = async () => {
  const { data } = await axios.get(route(`api.permissions.index`))

  return data
}

const usePermissionsQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`permissions`],
    queryFn: getPermissions,
    staleTime: Infinity,

    ...config,
  })

export default usePermissionsQuery
