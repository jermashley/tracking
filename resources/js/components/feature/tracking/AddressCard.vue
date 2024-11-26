<script setup>
import { faMapLocationDot } from '@fortawesome/pro-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { computed } from 'vue'

import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from '@/components/ui/tooltip'

const props = defineProps({
  type: {
    type: String,
    required: true,
    default: `Origin`,
  },
  location: {
    type: Object,
    required: true,
  },
})

const googleMapsLink = computed(() => {
  if (!props.location?.address) {
    return null
  }

  const addressParts = [
    props.location.address,
    props.location.address2,
    props.location.city,
    props.location.state,
    props.location.zipCode,
  ].filter(Boolean)

  const fullAddress = addressParts.join(`, `)

  const encodedAddress = encodeURIComponent(fullAddress)

  // Construct the Google Maps URL
  return `https://www.google.com/maps/search/?api=1&query=${encodedAddress}`
})
</script>

<template>
  <Card class="group w-full shadow-lg">
    <CardHeader>
      <CardTitle class="flex flex-row items-end space-x-4">
        <span>{{ type }}</span>

        <!-- <div class="mb-1 h-[0.125rem] w-full rounded-full bg-zinc-200" /> -->
      </CardTitle>
    </CardHeader>

    <CardContent>
      <section class="flex flex-col items-start justify-between space-y-4">
        <address class="flex flex-col text-sm not-italic">
          <span v-if="location?.name" class="text-lg font-semibold">
            {{ location?.name }}
          </span>

          <span v-if="location?.address">{{ location?.address }}</span>

          <span v-if="location?.address2">
            {{ location?.address2 }}
          </span>

          <span>
            {{ location?.city }},
            {{ location?.state }}
            {{ location?.zipCode }}
          </span>
        </address>

        <TooltipProvider>
          <Tooltip>
            <TooltipTrigger as-child>
              <Button
                v-if="googleMapsLink"
                variant="outline"
                size="sm"
                as="a"
                :href="googleMapsLink"
                target="_blank"
                rel="noopener noreferrer"
                class="w-full bg-background text-primary hover:bg-primary hover:text-primary-foreground"
              >
                <FontAwesomeIcon
                  class="mr-2 text-xl"
                  :icon="faMapLocationDot"
                  fixed-width
                />

                <span>Open in Maps</span>
              </Button>
            </TooltipTrigger>

            <TooltipContent>
              <p>Open in Google Maps</p>
            </TooltipContent>
          </Tooltip>
        </TooltipProvider>
      </section>
    </CardContent>
  </Card>
</template>
