<script setup>
import { StepperTrigger, useForwardProps } from 'radix-vue'
import { computed } from 'vue'

import { cn } from '@/lib/utils'

const props = defineProps({
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
})

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props

  return delegated
})

const forwarded = useForwardProps(delegatedProps)
</script>

<template>
  <StepperTrigger
    v-bind="forwarded"
    :class="
      cn(
        'flex flex-col items-center gap-2 rounded-md p-2 text-center',
        props.class,
      )
    "
  >
    <slot />
  </StepperTrigger>
</template>
