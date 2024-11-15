import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const testRunGet = async (id) => {
  const data = await axios.get(route(`api.testRun.show`, id))

  return data
}

const useTestRunQuery = ({ config = {}, id = null } = {}) =>
  useQuery({
    queryKey: [`testRuns`],
    queryFn: () => testRunGet(id),

    ...config,
  })

export default useTestRunQuery
