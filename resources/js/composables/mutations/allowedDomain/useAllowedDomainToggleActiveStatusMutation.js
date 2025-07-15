import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const toggleAllowedDomainActiveStatus = async (id) => {
  const { data } = await axios.patch(
    route(`api.admin.allowedDomains.toggleActiveStatus`, id),
  )

  return data
}

const useAllowedDomainToggleActiveStatusMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ allowedDomainId }) =>
      toggleAllowedDomainActiveStatus(allowedDomainId),
    ...config,
  })

export default useAllowedDomainToggleActiveStatusMutation
