<script setup>
import { faBan } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'

//
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="outline" size="sm">
        <FontAwesomeIcon class="mr-2" :icon="faBan" fixed-width />
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Kill Test</DialogTitle>

        <DialogDescription>
          Are you sure you want to kill this test?
        </DialogDescription>

        <DialogFooter>
          <DialogClose as-child>
            <Button variant="outline" size="sm">Cancel</Button>

            <Button variant="destructive" size="sm">Kill Test</Button>
          </DialogClose>
        </DialogFooter>
      </DialogHeader>
    </DialogContent>
  </Dialog>
</template>
