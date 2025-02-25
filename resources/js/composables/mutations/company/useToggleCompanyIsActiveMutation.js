import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const toggleCompanyIsActive = async (companyId) => {
  const { data } = await axios.patch(
    route(`api.companies.toggleActive`, companyId),
  )

  return data
}

const useToggleCompanyIsActiveMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ companyId }) => toggleCompanyIsActive(companyId),

    ...config,
  })

export default useToggleCompanyIsActiveMutation
