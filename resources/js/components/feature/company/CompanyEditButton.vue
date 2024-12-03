<script setup>
import { faEdit } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'

defineProps({
  company: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="ghost" size="sm">
        <FontAwesomeIcon :icon="faEdit" fixed-width />
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Edit {{ company.name }}</DialogTitle>
      </DialogHeader>

      <div>Edit the company info in the following form.</div>
    </DialogContent>
  </Dialog>
</template>
