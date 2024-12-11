<script setup>
import { faTrashAlt } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useQueryClient } from '@tanstack/vue-query'
import { ref } from 'vue'

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
import { useImageDestroyMutation } from '@/composables/mutations/image'

const props = defineProps({
  logo: {
    type: Object,
    required: true,
  },
})

const isOpen = ref(false)

const queryClient = useQueryClient()

const { mutate: destroyImage } = useImageDestroyMutation({
  config: {
    onSuccess: async () => {
      await queryClient.invalidateQueries({
        queryKey: [`images`, `logos`],
      })

      await queryClient.invalidateQueries({
        queryKey: [`companies`],
      })

      isOpen.value = false
    },
  },
})

const handleDelete = () => {
  destroyImage({ id: props.logo.id })
}

const cancelDialog = () => {
  isOpen.value = false
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button variant="destructive" size="xs" class="w-full">
        <FontAwesomeIcon :icon="faTrashAlt" fixed-width />
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Delete Logo {{ logo.name }}</DialogTitle>

        <DialogDescription>
          Are you sure you want to delete this logo?
        </DialogDescription>
      </DialogHeader>

      <DialogFooter
        class="flex flex-row items-center justify-end space-x-2 pt-4"
      >
        <Button variant="secondary" size="sm" @click="cancelDialog">
          Cancel
        </Button>

        <Button
          size="sm"
          type="button"
          variant="destructive"
          class=""
          @click="handleDelete"
        >
          Delete
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
