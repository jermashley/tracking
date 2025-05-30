<script setup>
import {
  faArrowRight,
  faBoxesStacked,
  faCalendarArrowDown,
  faCalendarArrowUp,
  faCalendarCheck,
  faExclamationTriangle,
  faFileSignature,
  faMapLocationDot,
  faTruckContainer,
  faWeightScale,
} from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Head, usePage } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { computed } from 'vue'

import AddressCard from '@/components/feature/tracking/AddressCard.vue'
import ShipmentDetail from '@/components/feature/tracking/ShipmentDetail.vue'
import StatusStepper from '@/components/feature/tracking/StatusStepper.vue'
import TrackingMap from '@/components/feature/tracking/TrackingMap.vue'
import TrackingLayout from '@/components/layout/page/TrackingLayout.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'

const {
  app: { name: appName },
} = usePage().props

const props = defineProps({
  trackingData: {
    type: Object,
    required: true,
  },
  company: {
    type: Object,
    required: true,
    default: null,
  },
  shipmentCoordinates: {
    type: Object,
    required: true,
    default: null,
  },
})

const bolNumber = computed(() => {
  return props.trackingData.data.trackingObject.bolNum
})

const proNumber = computed(() => {
  const proNumber = props.trackingData.data.trackingObject?.carrierPro

  const statusWithProNumber =
    props.trackingData.data.trackingObject?.allStatuses?.find(
      (status) => status.pro_number !== null,
    )

  return proNumber ?? statusWithProNumber?.pro_number
})

const statuses = computed(() => {
  return props.trackingData.data.trackingObject?.allStatuses
})

const numberOfPieces = computed(() => {
  return props.trackingData.data.trackingObject?.lineItems?.reduce(
    (previous, current) => {
      const currentPieces = Number(current.pieces) || 0

      return previous + currentPieces
    },
    0,
  )
})
</script>

<template>
  <Head>
    <title>{{ company?.name ?? appName }} - {{ proNumber }}</title>

    <meta
      name="description"
      content="Track and share shipment details with ease."
    />
  </Head>

  <TrackingLayout
    :banner-file-path="company?.banner?.file_path"
    :footer-file-path="company?.footer?.file_path"
  >
    <div class="flex flex-col gap-12">
      <Card class="w-full shadow-lg">
        <CardHeader>
          <CardTitle>Shipment Details</CardTitle>
        </CardHeader>

        <CardContent>
          <section class="grid grid-cols-1 gap-4 md:grid-cols-[1fr,auto]">
            <div
              class="grid grid-flow-col grid-cols-1 grid-rows-5 gap-x-8 gap-y-4 md:grid-cols-2 md:grid-rows-3"
            >
              <ShipmentDetail
                v-if="proNumber"
                :detail="proNumber"
                label="Tracking Number"
                :icon="faMapLocationDot"
                is-copyable
              />

              <ShipmentDetail
                v-if="bolNumber"
                :detail="bolNumber"
                label="Bill of Lading"
                :icon="faFileSignature"
                is-copyable
              />

              <ShipmentDetail
                :detail="trackingData.data.trackingObject.carrierName"
                label="Carrier"
                :icon="faTruckContainer"
              />

              <ShipmentDetail
                v-if="numberOfPieces"
                :detail="numberOfPieces"
                :label="`Piece${numberOfPieces > 1 ? `s` : ``}`"
                :icon="faBoxesStacked"
              />

              <ShipmentDetail
                :detail="`${trackingData.data.trackingObject.totalWeight} lb${
                  Number(trackingData.data.trackingObject.totalWeight) || 0 >= 1
                    ? `s`
                    : ``
                }`"
                label="Total Weight"
                :icon="faWeightScale"
              />
            </div>

            <div
              class="flex min-w-56 flex-col gap-4 border-t border-t-border pt-4 md:border-l md:border-t-0 md:border-l-border md:pl-4 md:pt-0"
            >
              <ShipmentDetail
                v-if="trackingData.data.trackingObject.actualDeliveryDate"
                :detail="
                  dayjs(
                    trackingData.data.trackingObject.actualDeliveryDate,
                  ).format('MMMM D, YYYY')
                "
                :icon="faCalendarCheck"
                label="Actual Delivery Date"
              />

              <ShipmentDetail
                v-if="
                  !trackingData.data.trackingObject.actualDeliveryDate &&
                  trackingData.data.trackingObject.estimatedDeliveryDate
                "
                :detail="
                  dayjs(
                    trackingData.data.trackingObject.estimatedDeliveryDate,
                  ).format('MMMM D, YYYY')
                "
                :icon="faCalendarArrowDown"
                label="Estimated Delivery Date"
              />

              <ShipmentDetail
                v-if="trackingData.data.trackingObject.actualPickupDate"
                :detail="
                  dayjs(
                    trackingData.data.trackingObject.actualPickupDate,
                  ).format('MMMM D, YYYY')
                "
                :icon="faCalendarCheck"
                label="Actual Pickup Date"
              />

              <ShipmentDetail
                v-if="
                  !trackingData.data.trackingObject.actualPickupDate &&
                  trackingData.data.trackingObject.estimatedPickupDate
                "
                :detail="
                  dayjs(
                    trackingData.data.trackingObject.estimatedDeliveryDate,
                  ).format('MMMM D, YYYY')
                "
                :icon="faCalendarArrowUp"
                label="Estimated Pickup Date"
              />
            </div>
          </section>
        </CardContent>
      </Card>

      <section
        class="flex flex-col items-stretch justify-between space-x-0 space-y-8 md:flex-row md:space-x-8 md:space-y-0"
      >
        <AddressCard
          :location="trackingData.data.trackingObject?.originLocation"
          type="Origin"
        />

        <FontAwesomeIcon
          class="rotate-90 transform self-center md:rotate-0"
          :icon="faArrowRight"
          fixed-width
        />

        <AddressCard
          :location="trackingData.data.trackingObject?.destinationLocation"
          type="Destination"
        />
      </section>

      <Card
        v-if="shipmentCoordinates && company?.enable_map"
        class="w-full shadow-lg"
      >
        <CardHeader>
          <CardTitle>Tracking Map</CardTitle>
        </CardHeader>

        <CardContent>
          <TrackingMap :shipment-coordinates="shipmentCoordinates[0]" />
        </CardContent>
      </Card>

      <section>
        <h3 class="mb-6 text-2xl font-semibold">Status History</h3>

        <StatusStepper v-if="statuses" :statuses="statuses" />

        <div v-else class="mt-24 flex flex-col items-center justify-center">
          <FontAwesomeIcon
            class="text-2xl text-amber-300"
            :icon="faExclamationTriangle"
            fixed-width
          />

          <p class="mt-2 text-center text-sm text-muted-foreground">
            No status history found...yet.
          </p>
        </div>
      </section>
    </div>
  </TrackingLayout>
</template>
