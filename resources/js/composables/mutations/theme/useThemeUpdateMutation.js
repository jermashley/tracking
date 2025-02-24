import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const updateTheme = async (themeId, formData) => {
  const { data } = await axios.patch(route(`api.formData.update`, themeId), {
    ...formData,
  })

  return data
}

const useThemeUpdateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id, formData }) => updateTheme(id, formData),

    ...config,
  })

export default useThemeUpdateMutation
