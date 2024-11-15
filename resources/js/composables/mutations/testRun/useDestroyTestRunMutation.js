import { useMutation } from '@tanstack/vue-query'
import axios from 'axios'

const testRunDestroy = async () => {
  const data = await axios.destroy(route(`api.testRun.index`))

  return data
}

const useDestroyTestRunMutation = ({ config = {}, id = null } = {}) =>
  useMutation({
    mutationKey: [`testRun`, `destroy`, id],
    mutationFn: testRunDestroy,

    ...config,
  })

export default useDestroyTestRunMutation
