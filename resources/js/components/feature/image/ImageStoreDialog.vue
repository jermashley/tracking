<script setup>
import { faRectangleHistoryCirclePlus } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="default" size="sm" class="w-full">
        <FontAwesomeIcon
          class="mr-2"
          :icon="faRectangleHistoryCirclePlus"
          fixed-width
        />

        <span>Add Image</span>
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Add New Image</DialogTitle>
      </DialogHeader>

      <div>A dialog to add new images to the gallery.</div>
    </DialogContent>
  </Dialog>
</template>
