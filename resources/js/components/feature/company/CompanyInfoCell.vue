<script setup>
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import {
  HoverCard,
  HoverCardContent,
  HoverCardTrigger,
} from '@/components/ui/hover-card'

defineProps({
  name: {
    type: String,
    required: true,
  },
  pipelineCompanyId: {
    type: Number,
    required: true,
  },
  phone: {
    type: String,
    required: false,
    default: null,
  },
  website: {
    type: String,
    required: false,
    default: null,
  },
  email: {
    type: String,
    required: false,
    default: null,
  },
  logo: {
    type: Object,
    required: false,
    default: null,
  },
})
</script>

<template>
  <div class="flex flex-row items-center justify-start space-x-6">
    <div v-if="logo?.file_path" class="relative aspect-square w-16">
      <img
        :src="`/${logo.file_path}`"
        class="absolute left-0 top-0 block h-full w-full scale-90 transform object-contain transition-all duration-300 group-hover:scale-95"
      />
    </div>

    <HoverCard :open-delay="300">
      <HoverCardTrigger as-child>
        <Button variant="link" class="p-0 underline">
          {{ name }}
        </Button>
      </HoverCardTrigger>

      <HoverCardContent class="w-96" align="start">
        <div class="flex flex-col items-start justify-start gap-4">
          <div class="flex w-full flex-row justify-between gap-1">
            <h4 class="text-xl font-semibold">{{ name }}</h4>

            <Badge v-if="pipelineCompanyId" variant="secondary">
              Pipeline ID: {{ pipelineCompanyId }}
            </Badge>
          </div>

          <div class="flex flex-col gap-4 text-sm">
            <p v-if="phone" class="flex flex-col items-start justify-start">
              <span class="font-semibold">Phone: </span>

              <Button variant="link" class="h-auto p-0 underline" as-child>
                <a :href="`tel:+1${phone.replace(/\D/g, ``)}`" target="_blank">
                  {{ phone }}
                </a>
              </Button>
            </p>

            <p v-if="website" class="flex flex-col items-start justify-start">
              <span class="font-semibold">Website: </span>

              <Button variant="link" class="h-auto p-0 underline" as-child>
                <a :href="website" target="_blank">{{ website }}</a>
              </Button>
            </p>

            <p v-if="email" class="flex flex-col items-start justify-start">
              <span class="font-semibold">Email: </span>

              <Button variant="link" class="h-auto p-0 underline" as-child>
                <a :href="`mailto:${email}`" target="_blank">{{ email }}</a>
              </Button>
            </p>
          </div>
        </div>
      </HoverCardContent>
    </HoverCard>
  </div>
</template>
