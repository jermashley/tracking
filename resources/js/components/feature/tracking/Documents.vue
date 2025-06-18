<script setup>
import { ref } from 'vue'

const props = defineProps({
  documents: {
    type: Array,
    required: true,
  },
})

const notEmptyDocumentsList = ref(true)
</script>
<template>
  <template v-if="notEmptyDocumentsList">
    <h2 class="mb-4 text-lg font-semibold">Shipment Documents</h2>
    <table>
      <thead>
        <tr>
          <th>Type</th>
          <th>Url</th>
          <th>Size</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="document in documents" :key="document.url">
          <td>{{ document.name }}</td>
          <td>
            &nbsp; &nbsp; <a :href="document.url" target="_blank">Download</a>
          </td>
          <td>&nbsp; &nbsp;{{ document.size }}</td>
        </tr>
      </tbody>
    </table>
  </template>
</template>
