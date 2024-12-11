import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getImages = async (imageTypeId) => {
  const { data } = await axios.get(route(`api.images.index`), {
    imageTypeId,
  })

  return data
}

const useImagesQuery = ({
  config = {},
  imageType = null,
  imageTypeId = null,
} = {}) =>
  useQuery({
    queryKey: [`images`, imageType],
    queryFn: () => getImages(imageTypeId),

    ...config,
  })

export default useImagesQuery
