<script setup>
import { faEdit, faImages } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import dayjs from 'dayjs'
import { VisuallyHidden } from 'radix-vue'

import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { useImagesQuery } from '@/composables/queries/image'

import LogoDestroyDialog from './LogoDestroyDialog.vue'
import LogoStoreDialog from './LogoStoreDialog.vue'

const { data: images, isError: imagesIsError } = useImagesQuery({
  imageType: `logos`,
  imageTypeId: 1,
})
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="secondary" size="sm">
        <FontAwesomeIcon :icon="faImages" fixed-width class="mr-2" />

        <span>Manage Logos</span>
      </Button>
    </DialogTrigger>

    <DialogContent class="w-full max-w-2xl">
      <VisuallyHidden as-child>
        <DialogDescription>A dialog to show company logos.</DialogDescription>
      </VisuallyHidden>

      <DialogHeader>
        <DialogTitle>Manage Logos</DialogTitle>
      </DialogHeader>

      <section
        v-if="images && !imagesIsError"
        class="flex flex-col items-stretch justify-start space-y-1"
      >
        <div
          v-for="image in images"
          :key="image.uuid"
          class="group flex flex-row items-center justify-start space-x-4 overflow-hidden rounded border border-transparent bg-transparent px-4 py-1 transition-colors duration-300 hover:border-muted-foreground/20 hover:bg-muted"
        >
          <div class="relative aspect-square w-20">
            <img
              :src="`/${image.file_path}`"
              class="absolute left-0 top-0 block h-full w-full scale-90 transform object-contain transition-all duration-300 group-hover:scale-95"
            />
          </div>

          <div class="flex w-full flex-col items-start justify-start">
            <p class="text-base font-semibold">{{ image.name }}</p>

            <p class="text-xs font-medium leading-none">
              {{ dayjs(image.created_at).format(`h:mm A MMMM DD, YYYY`) }}
            </p>
          </div>

          <div
            class="flex transform flex-row items-center justify-end space-x-2 transition-all duration-300"
          >
            <Button variant="secondary" size="xs" class="w-full">
              <FontAwesomeIcon :icon="faEdit" fixed-width />
            </Button>

            <LogoDestroyDialog :logo="image" />
          </div>
        </div>
      </section>

      <DialogFooter class="flex w-full flex-row items-stretch justify-start">
        <LogoStoreDialog />
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
