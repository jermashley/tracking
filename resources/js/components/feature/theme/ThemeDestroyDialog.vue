<script setup>
import { faTrashAlt } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { router } from '@inertiajs/vue3'
import { useQueryClient } from '@tanstack/vue-query'
import { ref } from 'vue'
import { useHasPermissions } from '@/composables/hooks/auth/useHasPermissions'
const { hasPermissions } = useHasPermissions()

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
import { useThemeDestroyMutation } from '@/composables/mutations/theme'

const props = defineProps({
  theme: {
    type: Object,
    required: true,
  },
})

const isOpen = ref(false)

const queryClient = useQueryClient()

const { mutate: destroyTheme } = useThemeDestroyMutation({
  config: {
    onSuccess: async () => {
      await queryClient.invalidateQueries({
        queryKey: [`themes`],
      })

      router.visit(route(`admin.theme.index`))
    },
  },
})

const handleDelete = () => {
  destroyTheme({ id: props.theme.id })
}

const cancelDialog = () => {
  isOpen.value = false
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <template v-if="hasPermissions('theme.delete')">
      <DialogTrigger as-child>
        <Button variant="destructive" size="sm">
          <FontAwesomeIcon class="mr-2" :icon="faTrashAlt" fixed-width />

          <span>Delete</span>
        </Button>
      </DialogTrigger>
    </template>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Delete {{ theme.name }}</DialogTitle>

        <DialogDescription>
          <p>
            A you sure you want to delete the theme
            <span class="font-semibold"> {{ theme.name }} </span>?
          </p>
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
