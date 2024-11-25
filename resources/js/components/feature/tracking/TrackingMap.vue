<script setup>
import TrimbleMaps from '@trimblemaps/trimblemaps-js'

const props = defineProps({
  coordinates: {
    type: Object,
    required: true,
  },
})

const myMap = TrimbleMaps.Map({
  container: `myMap`,
  center: new TrimbleMaps.LngLat(
    props.coordinates[0].lastLocation.coordinates.lng,
    props.coordinates[0].lastLocation.coordinates.lat,
  ),
  zoom: 3,
})
</script>

<template>
  <div id="trackingMap" />
</template>
