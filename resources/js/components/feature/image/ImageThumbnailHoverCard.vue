<script setup>
import { AspectRatio } from '@/components/ui/aspect-ratio'
import {
  HoverCard,
  HoverCardContent,
  HoverCardTrigger,
} from '@/components/ui/hover-card'
import { imageAssetUrl } from '@/composables/hooks/disks'

defineProps({
  image: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <HoverCard>
    <HoverCardTrigger as-child>
      <AspectRatio :ratio="1 / 1" class="">
        <img
          :src="imageAssetUrl({ filePath: image.file_path })"
          class="h-full w-full object-contain object-center"
        />
      </AspectRatio>
    </HoverCardTrigger>

    <HoverCardContent class="h-96 w-96">
      <AspectRatio :ratio="1 / 1" class="h-full w-full">
        <img
          :src="imageAssetUrl({ filePath: image.file_path })"
          class="h-full w-full object-contain object-center"
        />
      </AspectRatio>
    </HoverCardContent>
  </HoverCard>
</template>
