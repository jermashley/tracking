import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const updateTheme = async (themeId, formData) => {
  console.log(`themeId`, themeId)
  console.log(`formData`, formData)
  const { data } = await axios.patch(route(`api.themes.update`, themeId), {
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
