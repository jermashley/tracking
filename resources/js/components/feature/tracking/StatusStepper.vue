<script setup>
import {
  faCalendarClock,
  faCircleCheck,
  faEye,
  faLocationDot,
  faPlusMinus,
  faWaveSine,
} from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import dayjs from 'dayjs'

import { Button } from '@/components/ui/button'
import {
  Stepper,
  StepperDescription,
  StepperItem,
  StepperSeparator,
  StepperTitle,
  StepperTrigger,
} from '@/components/ui/stepper'
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from '@/components/ui/tooltip'

defineProps({
  statuses: {
    type: Array,
    required: true,
  },
})
</script>

<template>
  <Stepper
    orientation="vertical"
    class="mx-auto flex w-full flex-col-reverse justify-start gap-4"
  >
    <StepperItem
      v-for="(status, index) in statuses"
      :key="`${index}-${status.id}`"
      :step="index - statuses.length"
      class="group relative flex w-full items-start rounded-lg bg-transparent px-2 py-2 transition-all duration-300 hover:bg-gradient-to-r hover:from-background hover:to-primary/10 md:py-4"
    >
      <StepperSeparator
        v-if="index !== 0"
        class="absolute left-7 top-10 my-4 block h-[calc(100%-3rem)] w-px bg-muted group-data-[state=completed]:bg-primary/70 md:h-[calc(100%-2rem)]"
      />

      <StepperTrigger disabled class="relative flex">
        <FontAwesomeIcon
          v-if="index === statuses.length - 1"
          :icon="faCircleCheck"
          fixed-width
          class="absolute -mt-1 text-xl"
          :class="{
            'text-primary': index === statuses.length - 1,
            'animate-ping': index === statuses.length - 1,
          }"
        />

        <FontAwesomeIcon
          :icon="faCircleCheck"
          fixed-width
          class="-mt-1 text-xl"
          :class="{
            'text-primary/60': index !== statuses.length - 1,
            'text-primary': index === statuses.length - 1,
          }"
        />
      </StepperTrigger>

      <div class="flex w-full flex-col gap-4 md:gap-1">
        <StepperTitle
          class="whitespace-normal pr-24"
          :class="{
            'text-foreground': index === statuses.length - 1,
            'text-muted-foreground transition-colors duration-300 group-hover:text-foreground':
              index !== statuses.length - 1,
          }"
        >
          {{ status.current_status }}
        </StepperTitle>

        <StepperDescription
          :class="{
            'text-foreground': index === statuses.length - 1,
            'text-muted-foreground transition-colors duration-300 group-hover:text-foreground':
              index !== statuses.length - 1,
          }"
          class="flex w-full flex-col items-start gap-y-4 text-xs transition md:flex-row md:items-center md:gap-x-6 md:gap-y-0 lg:text-sm"
        >
          <div class="flex flex-row items-center gap-2">
            <FontAwesomeIcon
              :icon="faCalendarClock"
              class="text-primary"
              :class="{
                'text-foreground': index === statuses.length - 1,
              }"
              fixed-width
            />

            <TooltipProvider
              v-if="!status.status_date_time"
              class="text-[0.625rem]"
            >
              <Tooltip>
                <TooltipTrigger>
                  <FontAwesomeIcon
                    :icon="faWaveSine"
                    class="text-xs text-primary"
                    :class="{
                      'text-foreground': index === statuses.length - 1,
                    }"
                    fixed-width
                  />
                </TooltipTrigger>

                <TooltipContent>
                  <p>Approximate time.</p>
                </TooltipContent>
              </Tooltip>
            </TooltipProvider>

            <span>
              {{
                dayjs(status.status_date_time ?? status.timestamp).format(
                  'ddd DD, YYYY, h:mm A',
                )
              }}
            </span>
          </div>

          <div
            v-if="status.current_location"
            class="flex flex-row items-center gap-2"
          >
            <FontAwesomeIcon
              :icon="faLocationDot"
              class="text-primary"
              :class="{
                'text-foreground': index === statuses.length - 1,
              }"
              fixed-width
            />

            <span>{{ status.current_location }}</span>
          </div>
        </StepperDescription>
      </div>
    </StepperItem>
  </Stepper>
</template>
