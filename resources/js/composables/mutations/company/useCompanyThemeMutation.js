import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const setCompanyTheme = async (companyId, themeId) => {
  const { data } = await axios.patch(
    route(`api.companies.setTheme`, companyId),
    {
      theme_id: themeId,
    },
  )

  return data
}

const useCompanyThemeMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ companyId, themeId }) => setCompanyTheme(companyId, themeId),

    ...config,
  })

export default useCompanyThemeMutation
