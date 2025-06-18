import { useQuery } from '@tanstack/vue-query'
import axios from 'axios'

const getShipmentDocuments = async (formData) => {
  const { data } = await axios.post(route(`api.shipmentDocuments`), formData)
  return data
}

const useShipmentDocumentsQuery = ({
  config = {},
  trackingNumber = ``,
  companyId = ``,
} = {}) =>
  useQuery({
    queryKey: [`shipmentDocuments`, trackingNumber, companyId],
    queryFn: () =>
      getShipmentDocuments({
        trackingNumber: trackingNumber?.value ?? trackingNumber,
        companyId,
      }),

    retry: false,
    select: ({ shipmentDocuments }) => {
      const data = {
        shipmentDocuments: shipmentDocuments,
      }
      return data
    },

    ...config,
  })

export default useShipmentDocumentsQuery
