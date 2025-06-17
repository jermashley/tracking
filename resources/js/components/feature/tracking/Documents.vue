<script setup>
const props = defineProps({
  documents: {
    type: Array,
    required: true,
  },
})
</script>

<template>
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
