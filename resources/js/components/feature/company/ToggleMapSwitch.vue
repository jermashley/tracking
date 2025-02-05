<script setup>
import { useQueryClient } from '@tanstack/vue-query'

import { Switch } from '@/components/ui/switch'
import { useToggleCompanyEnableMapMutation } from '@/composables/mutations/company'

const props = defineProps({
  companyId: {
    type: Number,
    required: true,
  },
  id: {
    type: String,
    required: true,
  },
  name: {
    type: String,
    required: true,
  },
  value: {
    type: Boolean,
    required: true,
  },
})

const queryClient = useQueryClient()

const { mutate: toggleEnableMap, isPending } =
  useToggleCompanyEnableMapMutation({
    config: {
      onSuccess: async () => {
        await queryClient.invalidateQueries({
          queryKey: [`companies`],
        })
      },
    },
  })

const handleToggle = () => {
  toggleEnableMap({
    companyId: props.companyId,
  })
}
</script>

<template>
  <Switch
    :id="id"
    :name="name"
    :checked="value"
    :disabled="isPending"
    @update:checked="handleToggle"
  />
</template>
