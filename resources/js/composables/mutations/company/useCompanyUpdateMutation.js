import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const updateCompany = async (companyId, formData) => {
  const { data } = await axios.patch(route(`api.companies.update`, companyId), {
    ...formData,
  })

  return data
}

const useCompanyUpdateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id, formData }) => updateCompany(id, formData),

    ...config,
  })

export default useCompanyUpdateMutation
