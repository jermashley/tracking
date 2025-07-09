import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getUsers = async () => {
  const { data } = await axios.get(route(`api.admin.users.index`))

  return data
}

const useUsersQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`users`],
    queryFn: getUsers,

    ...config,
  })

export default useUsersQuery
