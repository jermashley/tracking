import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getImageTypes = async () => {
  const { data } = await axios.get(route(`api.imageTypes.index`))

  return data
}

const useImageTypesQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`imageTypes`],
    queryFn: getImageTypes,

    ...config,
  })

export default useImageTypesQuery
