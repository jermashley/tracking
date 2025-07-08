import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const destroyCompanyApiTokens = async (id) => {
  const { data } = await axios.delete(
    route(`api.admin.companyApiTokens.destroy`, id),
  )

  return data
}

const useCompanyApiTokenDestroyMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id }) => destroyCompanyApiTokens(id),

    ...config,
  })

export default useCompanyApiTokenDestroyMutation
