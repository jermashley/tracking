<script setup>
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

import ShipmentDetailsAndTracking from '@/components/feature/tracking/ShipmentDetailsAndTracking.vue'
import AuthenticatedLayout from '@/components/layout/page/AuthenticatedLayout.vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { useTrackShipmentQuery } from '@/composables/queries/trackShipment'

const trackingNumber = ref(``)
const searchOption = ref(``)

const { data, refetch } = useTrackShipmentQuery({
  config: {
    enabled: false,
  },

  trackingNumber: trackingNumber,
  searchOption: searchOption,
})

const resetForm = () => {
  trackingNumber.value = ``
  searchOption.value = ``
}

const submitForm = () => {
  refetch()
}
</script>

<template>
  <Head title="Tracking" />

  <AuthenticatedLayout title="Tracking">
    <Card class="group w-full shadow-lg">
      <CardHeader>
        <CardTitle class="flex flex-row items-end space-x-4">
          Track a Shipment
        </CardTitle>
      </CardHeader>

      <CardContent>
        <section
          class="flex flex-col items-stretch justify-start space-x-0 space-y-4 md:flex-row md:space-x-4 md:space-y-0"
        >
          <div class="w-full">
            <Label for="trackingNumber">Tracking Number</Label>

            <Input
              id="trackingNumber"
              v-model="trackingNumber"
              name="trackingNumber"
              type="text"
              placeholder="Enter tracking number"
            />
          </div>

          <div class="w-full">
            <Label for="searchOption">Type</Label>

            <Select
              id="searchOption"
              v-model="searchOption"
              name="searchOption"
            >
              <SelectTrigger>
                <SelectValue placeholder="Select a type" />
              </SelectTrigger>

              <SelectContent>
                <SelectItem value="bol">Bill of Lading</SelectItem>
                <SelectItem value="carrierPro">Carrier PRO</SelectItem>
              </SelectContent>
            </Select>
          </div>
        </section>

        <section class="mt-6 flex flex-row items-center justify-end space-x-2">
          <Button variant="outline" size="sm" @click="resetForm">Reset</Button>

          <Button variant="default" size="sm" @click="submitForm">
            Submit
          </Button>
        </section>
      </CardContent>
    </Card>

    <div v-if="data?.trackingData" class="mt-8">
      <ShipmentDetailsAndTracking
        :tracking-data="data?.trackingData"
        :company="data?.company"
        :shipment-coordinates="data?.shipmentCoordinates"
        :use-track-shipment-query-refetch="refetch"
        :last-updated="dataUpdatedAt"
      />
    </div>
  </AuthenticatedLayout>
</template>
