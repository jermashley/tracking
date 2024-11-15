<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue'

const props = defineProps({
  logFilePath: {
    type: String,
    required: true,
  },
})

const logElement = ref(null)

const logUrl = props.logFilePath

let eventSource

const streamLog = () => {
  eventSource = new EventSource(logUrl)

  eventSource.onmessage = (event) => {
    logElement.value.textContent += event.data + `\n`

    logElement.value.scrollTop = logElement.value.scrollHeight // Auto-scroll to the bottom
  }

  eventSource.onerror = () => {
    console.error(`Error occurred while streaming log.`)

    eventSource.close()
  }
}

onMounted(() => {
  streamLog()
})

onBeforeUnmount(() => {
  if (eventSource) {
    eventSource.close()
  }
})
</script>

<template>
  <div>
    <h3>Log Stream</h3>

    <div id="log" ref="log"></div>
  </div>
</template>
