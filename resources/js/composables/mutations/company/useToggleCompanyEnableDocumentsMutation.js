import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const toggleCompanyEnableDocuments = async (companyId) => {
  const { data } = await axios.patch(
    route(`api.companies.toggleDocumentsOption`, companyId),
  )

  return data
}

const useToggleCompanyEnableDocumentsMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ companyId }) => toggleCompanyEnableDocuments(companyId),

    ...config,
  })

export default useToggleCompanyEnableDocumentsMutation
