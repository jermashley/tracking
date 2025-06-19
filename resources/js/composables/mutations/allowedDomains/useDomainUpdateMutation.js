// resources/js/composables/mutations/domain/useDomainUpdateMutation.js
import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const updateDomain = async ({ id, domain }) => {
  console.log({ id, domain })
  const { data } = await axios.patch(route(`api.allowedDomains.update`, id), {
    domain,
  })

  return data
}

const useDomainUpdateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id, domain }) => updateDomain({ id, domain }),
    ...config,
  })

export default useDomainUpdateMutation
