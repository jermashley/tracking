import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const createDomain = async ({ domain }) => {
  const { data } = await axios.post(route(`api.allowedDomains.store`), {
    domain,
  })
  return data
}

const useDomainCreateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ domain }) => createDomain({ domain }),
    ...config,
  })

export default useDomainCreateMutation
