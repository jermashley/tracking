import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const testRunsGet = async () => {
  const data = await axios.get(route(`api.testRun.index`))

  return data
}

const useTestRunsQuery = ({ config = {} } = {}) =>
  useQuery({
    queryKey: [`testRuns`],
    queryFn: testRunsGet,
    select: ({ data }) => data,

    ...config,
  })

export default useTestRunsQuery
