<script setup>
import { faTrashAlt } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { router } from '@inertiajs/vue3'
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
import { usePermissionDestroyMutation } from '@/composables/mutations/permission'

const props = defineProps({
  permission: {
    type: Object,
    required: true,
  },
})

const isOpen = ref(false)

const queryClient = useQueryClient()

const { mutate: destroyPermission } = usePermissionDestroyMutation({
  config: {
    onSuccess: async () => {
      debugger;
      await queryClient.invalidateQueries({
        queryKey: [`permissions`],
      })

      router.visit(route(`admin.permissions.index`))
    },
  },
})

const handleDelete = () => {
  destroyPermission({ id: props.permission.id })
}

const cancelDialog = () => {
  isOpen.value = false
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button variant="destructive" size="sm">
        <FontAwesomeIcon class="mr-2" :icon="faTrashAlt" fixed-width />

        <span>Delete</span>
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Delete {{ permission.name }}</DialogTitle>

        <DialogDescription>
          <p>
            A you sure you want to delete the permission
            <span class="font-semibold"> {{ permission.name }} </span>?
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
