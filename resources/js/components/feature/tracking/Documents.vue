<script setup>
const props = defineProps({
  documents: {
    type: Array,
    required: true,
  },
})
</script>

<template>
  <div>
    <h3>Shipment Documents</h3>
    <ul>
      <li v-for="document in documents" :key="document.url">
        {{ document.name }} - {{ document.url }}
      </li>
    </ul>
  </div>
</template>
