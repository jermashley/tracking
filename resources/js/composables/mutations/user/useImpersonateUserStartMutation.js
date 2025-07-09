import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const impersonateUserStart = async (userId) => {
  const { data } = await axios.post(
    route(`api.admin.impersonate.start`, userId),
  )

  return data
}

const useImpersonateUserStartMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: impersonateUserStart,

    ...config,
  })

export default useImpersonateUserStartMutation
