import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const destroyAllowedDomain = async (id) => {
  const { data } = await axios.delete(
    route(`api.admin.allowedDomains.destroy`, id),
  )

  return data
}

const useAllowedDomainDestroyMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationKey: [`allowedDomain`, `destroy`],
    mutationFn: (id) => destroyAllowedDomain(id),

    ...config,
  })

export default useAllowedDomainDestroyMutation
