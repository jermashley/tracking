import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const destroyTheme = async (id) => {
  const { data } = await axios.delete(route(`api.themes.destroy`, id))

  return data
}

const useThemeDestroyMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id }) => destroyTheme(id),

    ...config,
  })

export default useThemeDestroyMutation
