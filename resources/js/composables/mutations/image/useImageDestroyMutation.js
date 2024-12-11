import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const destroyImage = async (id) => {
  const { data } = await axios.delete(route(`api.images.destroy`, id))

  return data
}

const useImageDestroyMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ id }) => destroyImage(id),

    ...config,
  })

export default useImageDestroyMutation
