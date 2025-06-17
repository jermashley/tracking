<script setup>
import {ref} from "vue";

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
    <h2 class="text-lg font-semibold mb-4">Shipment Documents</h2>
    <table>
      <thead>
        <tr>
          <th>Type</th>
          <th>URL</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="document in documents" :key="document.url">
          <td>{{ document.name }}</td>
          <td>&nbsp; &nbsp; <a :href="document.url" target="_blank">Download</a></td>
        </tr>
      </tbody>
    </table>
  </template>
</template>
