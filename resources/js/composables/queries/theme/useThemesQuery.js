import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getThemes = async () => {
  const { data } = await axios.get(route(`api.themes.index`))

  return data
}

const useThemesQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`themes`],
    queryFn: getThemes,
    staleTime: Infinity,
    cacheTime: Infinity,

    ...config,
  })

export default useThemesQuery
