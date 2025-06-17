import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getRoles = async (themeId) => {
  const { data } = await axios.get(route(`api.theme.show`, themeId))

  return data
}

const useThemeQuery = ({ config = {}, id = null } = {}) =>
  useQuery({
    queryKey: [`theme`, id],
    queryFn: () => getTheme(id),

    ...config,
  })

export default useThemeQuery
