import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const createCompany = async (formData) => {
  const { data } = await axios.post(route(`api.companies.store`), formData)

  return data
}

const useCompanyCreateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ formData }) => createCompany(formData),

    ...config,
  })

export default useCompanyCreateMutation
