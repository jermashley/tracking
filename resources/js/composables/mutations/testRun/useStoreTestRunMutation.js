import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const testRunPost = async (formData) => {
  const data = await axios.post(route(`api.testRun.store`), formData)

  return data
}

const useStoreTestRunMutation = ({ config = {} } = {}) =>
  useMutation({
    mutationKey: [`testRun`, `store`],
    mutationFn: ({ formData = {} } = {}) => testRunPost(formData),

    ...config,
  })

export default useStoreTestRunMutation
