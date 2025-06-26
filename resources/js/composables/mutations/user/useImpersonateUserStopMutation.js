import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const impersonateUserStop = async () => {
  const { data } = await axios.post(route(`api.impersonate.stop`))

  return data
}

const useImpersonateUserStopMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: impersonateUserStop,

    ...config,
  })

export default useImpersonateUserStopMutation
