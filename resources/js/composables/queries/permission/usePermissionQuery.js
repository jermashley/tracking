import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getPermission = async (id) => {
  const { data } = await axios.get(route(`api.admin.permissions.show`, id))

  return data
}

const usePermissionQuery = ({ config = {}, id = null } = {}) =>
  useQuery({
    queryKey: [`permission`, id],
    queryFn: () => getPermission(id),
    staleTime: Infinity,

    ...config,
  })

export default usePermissionQuery
