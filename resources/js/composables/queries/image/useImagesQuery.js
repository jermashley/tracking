import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getImages = async () => {
  const { data } = await axios.get(route(`api.images.index`))

  return data
}

const useImagesQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`images`],
    queryFn: getImages,

    ...config,
  })

export default useImagesQuery
