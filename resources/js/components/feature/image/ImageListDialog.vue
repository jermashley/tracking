<script setup>
import { faImages } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { useImagesQuery } from '@/composables/queries/image'

import ImageStoreDialog from './ImageStoreDialog.vue'

const { data: images, isError } = useImagesQuery()
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="outline" size="sm">
        <FontAwesomeIcon :icon="faImages" fixed-width class="mr-2" />

        <span>Manage Images</span>
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Manage Images</DialogTitle>
      </DialogHeader>

      <div
        v-if="images && !isError"
        class="grid grid-cols-[repeat(auto-fit,minmax(128px,1fr))] gap-2"
      >
        <div
          v-for="image in images"
          :key="image.uuid"
          class="group relative rounded border-2 border-muted-foreground/20 bg-muted pt-[100%]"
        >
          <img
            :src="image.file_path"
            class="absolute left-0 top-0 block h-full w-full scale-90 transform object-contain transition-all duration-300 group-hover:scale-95"
          />
        </div>
      </div>

      <DialogFooter class="flex w-full flex-row items-stretch justify-start">
        <ImageStoreDialog />
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
