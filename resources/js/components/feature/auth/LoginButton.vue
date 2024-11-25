<script setup>
import { faMicrosoft } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import Button from '@/components/ui/button/Button.vue'

defineProps({
  provider: {
    type: String,
    required: true,
  },
  size: {
    type: String,
    default: `default`,
  },
})
</script>

<template>
  <Button :size="size" as="a" :href="route('oauth.redirect', provider)">
    <FontAwesomeIcon class="mr-2" :icon="faMicrosoft" fixed-width />

    <span>Login with Microsoft</span>
  </Button>
</template>
