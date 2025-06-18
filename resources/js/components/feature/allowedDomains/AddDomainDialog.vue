<script setup>
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
import { Input } from '@/components/ui/input'
import useDomainCreateMutation from '@/composables/mutations/allowedDomains/useDomainCreateMutation'

const isOpen = ref(false)
const domain = ref(``)
const errors = ref(null)
const queryClient = useQueryClient()

const { mutate: createDomain } = useDomainCreateMutation({
  config: {
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: [`allowed-domains`] })
      isOpen.value = false
      domain.value = ``
    },
    onError: (err) => {
      errors.value = err.response?.data?.errors ?? {}
    },
  },
})

const handleCreate = () => {
  createDomain({ domain: domain.value })
}

const cancelDialog = () => {
  isOpen.value = false
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button size="sm"> Add Domain </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Add Allowed Domain</DialogTitle>
        <DialogDescription>
          Enter a domain you want to allow (e.g., <code>example.com</code>).
        </DialogDescription>
      </DialogHeader>

      <Input v-model="domain" placeholder="domain.com" />
      <p v-if="errors?.domain" class="mt-1 text-sm text-red-600">
        {{ errors.domain }}
      </p>

      <DialogFooter
        class="flex flex-row items-center justify-end space-x-2 pt-4"
      >
        <Button variant="secondary" size="sm" @click="cancelDialog">
          Cancel
        </Button>
        <Button size="sm" @click="handleCreate"> Save </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
