<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

import ShipmentDetailsAndTracking from '@/components/feature/tracking/ShipmentDetailsAndTracking.vue'
import TrackingLayout from '@/components/layout/page/TrackingLayout.vue'
import { useTrackShipmentQuery } from '@/composables/queries/trackShipment'

const params = new URLSearchParams(window.location.search)

const {
  app: { name: appName },
  initialTrackingData,
  initialCompany,
  initialShipmentCoordinates,
  initialShipmentDocuments,
} = usePage().props

const initialData = {
  trackingData: initialTrackingData,
  company: initialCompany,
  shipmentCoordinates: initialShipmentCoordinates,
  shipmentDocuments: initialShipmentDocuments,
}

const { data, refetch, dataUpdatedAt } = useTrackShipmentQuery({
  trackingNumber: initialTrackingData.data[0].bolNum,
  searchOption: params.get(`searchOption`),
  companyId: initialCompany?.pipeline_company_id ?? ``,

  config: {
    initialData,
  },
})

const proNumber = computed(() => {
  const proNumber = data.value.trackingData.carrierPro

  const statusWithProNumber = data.value.trackingData.allStatuses?.find(
    (status) => status.pro_number !== null,
  )

  return proNumber ?? statusWithProNumber?.pro_number
})
</script>

<template>
  <Head>
    <title v-if="data">
      {{ data.company?.name ?? appName }} - {{ proNumber }}
    </title>

    <meta
      name="description"
      content="Track and share shipment details with ease."
    />
  </Head>

  <TrackingLayout
    :banner-file-path="data?.company?.banner?.file_path"
    :footer-file-path="data?.company?.footer?.file_path"
  >
    <ShipmentDetailsAndTracking
      :tracking-data="data?.trackingData"
      :company="data?.company"
      :shipment-coordinates="data?.shipmentCoordinates"
      :shipment-documents="data?.shipmentDocuments"
      :use-track-shipment-query-refetch="refetch"
      :last-updated="dataUpdatedAt"
    />
  </TrackingLayout>
</template>
