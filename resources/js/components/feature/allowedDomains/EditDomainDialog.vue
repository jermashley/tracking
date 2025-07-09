<script setup>
import { faEdit } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useQueryClient } from '@tanstack/vue-query'
import { ref, watch } from 'vue'

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
import useDomainUpdateMutation from '@/composables/mutations/allowedDomains/useDomainUpdateMutation'

const props = defineProps({
  domain: {
    type: Object,
    required: true,
  },
})

const isOpen = ref(false)
const domainValue = ref(``)
const errors = ref(null)
const queryClient = useQueryClient()

watch(isOpen, (open) => {
  if (open) {
    domainValue.value = props.domain.domain
    errors.value = null
  }
})

const { mutate: updateDomain } = useDomainUpdateMutation({
  config: {
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: [`allowed-domains`] })
      isOpen.value = false
    },
    onError: (err) => {
      errors.value = err.response?.data?.errors ?? {}
    },
  },
})

const handleUpdate = () => {
  updateDomain({ id: props.domain.id, domain: domainValue.value })
}

const cancelDialog = () => {
  isOpen.value = false
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button variant="outline" size="sm">
        <FontAwesomeIcon :icon="faEdit" fixed-width class="mr-1" />
        Edit
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Edit Domain</DialogTitle>
        <DialogDescription>
          Update the domain name for
          <span class="font-semibold">{{ props.domain.domain }}</span
          >.
        </DialogDescription>
      </DialogHeader>

      <Input v-model="domainValue" placeholder="domain.com" />
      <p v-if="errors?.domain" class="mt-1 text-sm text-red-600">
        {{ errors.domain }}
      </p>

      <DialogFooter
        class="flex flex-row items-center justify-end space-x-2 pt-4"
      >
        <Button variant="secondary" size="sm" @click="cancelDialog">
          Cancel
        </Button>
        <Button size="sm" @click="handleUpdate"> Update </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
