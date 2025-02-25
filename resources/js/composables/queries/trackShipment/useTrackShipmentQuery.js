import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const trackShipment = async (formData) => {
  const { data } = await axios.post(route(`api.trackShipment`), formData)

  return data
}

const useTrackShipmentQuery = ({
  config = {},
  trackingNumber = ``,
  searchOption = ``,
  companyId = ``,
  zipCode = ``,
} = {}) =>
  useQuery({
    queryKey: [
      `trackShipment`,
      trackingNumber,
      searchOption,
      companyId,
      zipCode,
    ],
    queryFn: () =>
      trackShipment({ trackingNumber, searchOption, companyId, zipCode }),

    retry: false,
    select: ({ data }) => {
      console.log(data)
      return data
    },

    ...config,
  })

export default useTrackShipmentQuery
