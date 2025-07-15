import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getUser = async (userId) => {
  const { data } = await axios.get(route(`api.admin.users.show`, userId))

  return data
}

const useUserQuery = ({ userId, config = {} } = {}) =>
  useQuery({
    queryKey: [`user`, userId],
    queryFn: () => getUser(userId),

    ...config,
  })

export default useUserQuery
