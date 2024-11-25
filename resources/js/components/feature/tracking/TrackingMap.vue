<script setup>
import TrimbleMaps from '@trimblemaps/trimblemaps-js'
import { onMounted, useTemplateRef } from 'vue'

const props = defineProps({
  shipmentCoordinates: {
    type: Object,
    required: true,
  },
})

const trackingMap = useTemplateRef(`trackingMap`)

onMounted(() => {
  TrimbleMaps.APIKey = import.meta.env.VITE_TRIMBLE_API_KEY

  const myMap = new TrimbleMaps.Map({
    container: trackingMap.value,
    center: new TrimbleMaps.LngLat(
      props.shipmentCoordinates.lastLocation.coordinates.lng,
      props.shipmentCoordinates.lastLocation.coordinates.lat,
    ),
    zoom: 3,
  })

  const simplifiedCoordinates =
    props.shipmentCoordinates?.allKnownLocations?.map((locations) => [
      locations.coordinates.lng,
      locations.coordinates.lat,
    ])

  console.log(`simplifiedCoordinates`, simplifiedCoordinates)

  const coordinates = simplifiedCoordinates.map(
    (simplifiedCoordinate) =>
      new TrimbleMaps.LngLat(simplifiedCoordinate[0], simplifiedCoordinate[1]),
  )

  console.log(`coordinates`, coordinates)

  const myRoute = new TrimbleMaps.Route({
    routeId: `myRoute`,
    stops: coordinates,
  })

  myMap.on(`load`, () => myRoute.addTo(myMap))
})
</script>

<template>
  <div
    id="trackingMap"
    ref="trackingMap"
    class="h-[25rem] w-full overflow-hidden rounded [&_canvas]:!rounded"
  />
</template>
