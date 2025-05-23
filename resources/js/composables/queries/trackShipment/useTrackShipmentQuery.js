import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const trackShipment = async (formData) => {
  const { data } = await axios.post(route(`api.shipmentTracking`), formData)

  return data
}

const useTrackShipmentQuery = ({
  config = {},
  trackingNumber = ``,
  searchOption = ``,
  companyId = ``,
} = {}) =>
  useQuery({
    queryKey: [`trackShipment`, trackingNumber, searchOption, companyId],
    queryFn: () => trackShipment({ trackingNumber, searchOption, companyId }),

    retry: false,
    select: ({ trackingData, company, shipmentCoordinates }) => {
      const data = {
        trackingData: trackingData.data[0],
        company,
        shipmentCoordinates,
      }

      return data
    },

    ...config,
  })

export default useTrackShipmentQuery
