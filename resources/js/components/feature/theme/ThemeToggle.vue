<script setup>
import { faMoon, faSun } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { usePage } from '@inertiajs/vue3'
import { onMounted, watch } from 'vue'

import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group'
import { useSystemTheme } from '@/composables/hooks/theme'

const { theme: systemTheme } = useSystemTheme()

const {
  company: {
    theme: { colors },
  },
} = usePage().props

const activateTheme = () => {
  switch (systemTheme.value) {
    case `light`:
      document.documentElement.style.setProperty(
        `--primary`,
        colors.root.primary,
      )
      document.documentElement.style.setProperty(
        `--primary-foreground`,
        colors.root.primaryForeground,
      )
      break
    case `dark`:
      document
        .getElementsByClassName(`dark`)[0]
        .style.setProperty(`--primary`, colors.dark.primary)
      document
        .getElementsByClassName(`dark`)[0]
        .style.setProperty(
          `--primary-foreground`,
          colors.dark.primaryForeground,
        )
      break
    // Add dark case if needed in the future
    default:
      console.warn(`Unexpected theme value: ${systemTheme.value}`)
      break
  }
}

watch(systemTheme, activateTheme)

onMounted(() => {
  activateTheme()
})
</script>

<template>
  <ToggleGroup
    v-model="systemTheme"
    type="single"
    size="sm"
    :default-value="systemTheme"
    :model-value="systemTheme"
  >
    <ToggleGroupItem value="light">
      <FontAwesomeIcon class="" :icon="faSun" fixed-width />
    </ToggleGroupItem>

    <ToggleGroupItem value="dark">
      <FontAwesomeIcon class="" :icon="faMoon" fixed-width />
    </ToggleGroupItem>
  </ToggleGroup>
</template>
