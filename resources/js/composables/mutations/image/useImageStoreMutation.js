import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const storeImage = async (formData) => {
  const { data } = await axios.post(route(`api.images.store`), formData, {
    headers: {
      'Content-Type': `multipart/form-data`,
    },
  })

  return data
}

const useImageStoreMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationFn: ({ formData }) => storeImage(formData),

    ...config,
  })

export default useImageStoreMutation
