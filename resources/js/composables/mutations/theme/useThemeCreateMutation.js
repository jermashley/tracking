import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const createTheme = async (formData) => {
  const { data } = await axios.post(route(`api.formData.store`), {
    ...formData,
  })

  return data
}

const useThemeCreateMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ formData }) => createTheme(formData),

    ...config,
  })

export default useThemeCreateMutation
