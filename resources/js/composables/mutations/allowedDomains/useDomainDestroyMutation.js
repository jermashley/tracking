import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const destroyDomain = async (id) => {
  const { data } = await axios.delete(route(`api.allowedDomains.destroy`, id))
  return data
}

const useDomainDestroyMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id }) => destroyDomain(id),
    ...config,
  })

export default useDomainDestroyMutation
