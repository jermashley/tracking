import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const destroyCompany = async (id) => {
  const { data } = await axios.delete(route(`api.companies.destroy`, id))

  return data
}

const usePermissionDestroyMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id }) => destroyCompany(id),

    ...config,
  })

export default usePermissionDestroyMutation
