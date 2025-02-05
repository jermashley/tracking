<script setup>
import { faCircle } from '@fortawesome/pro-solid-svg-icons'
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
import { Label } from '@/components/ui/label'
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group'
import { useCompanyThemeMutation } from '@/composables/mutations/company'
import { useThemesQuery } from '@/composables/queries/theme'

const props = defineProps({
  companyId: {
    type: Number,
    required: true,
  },
  currentTheme: {
    type: Object,
    required: true,
  },
})

const isOpen = ref(false)

const queryClient = useQueryClient()

const { data, isError } = useThemesQuery()

const { mutate: setCompanyTheme } = useCompanyThemeMutation({
  config: {
    onSuccess: async () => {
      await queryClient.invalidateQueries({
        queryKey: [`companies`],
      })

      isOpen.value = false
    },
  },
})

const selectedTheme = ref(`${props.currentTheme?.id}`)

const handleSave = () => {
  setCompanyTheme({
    companyId: props.companyId,
    themeId: selectedTheme.value,
  })
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button
        variant="outline"
        size="sm"
        class="flex flex-row items-center justify-center"
      >
        <FontAwesomeIcon
          :icon="faCircle"
          class="z-10 text-lg"
          fixed-width
          :style="{
            color: currentTheme
              ? `hsl(${currentTheme?.colors?.root.primary})`
              : `hsl(var(--primary))`,
          }"
        />

        <FontAwesomeIcon
          :icon="faCircle"
          class="-ml-3 text-lg"
          :class="{
            'stroke-foreground stroke-[6]': !currentTheme,
          }"
          fixed-width
          :style="{
            color: currentTheme
              ? `hsl(${currentTheme?.colors?.root.accent})`
              : `hsl(var(--background))`,
          }"
        />
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Select a theme</DialogTitle>

        <DialogDescription>
          Select a theme from the following list.
        </DialogDescription>
      </DialogHeader>

      <div>
        <RadioGroup
          v-if="data && !isError"
          v-model:model-value="selectedTheme"
          :default-value="`${currentTheme?.id}`"
          orientation="vertical"
        >
          <div
            v-for="theme in data"
            :key="theme.uuid"
            class="flex flex-row items-center justify-start space-x-2 rounded bg-transparent px-2 py-2 transition-all duration-300 hover:bg-secondary"
          >
            <RadioGroupItem :id="`${theme.id}`" :value="`${theme.id}`" />

            <Label
              :for="`${theme.id}`"
              class="flex w-full flex-row items-center justify-between text-base font-semibold"
            >
              <span>{{ theme.name }}</span>

              <div class="flex flex-row items-center justify-center">
                <FontAwesomeIcon
                  :icon="faCircle"
                  class="z-10 text-lg"
                  fixed-width
                  :style="{
                    color: `hsl(${theme.colors?.root.primary})`,
                  }"
                />

                <FontAwesomeIcon
                  :icon="faCircle"
                  class="-ml-3 text-lg"
                  fixed-width
                  :style="{
                    color: `hsl(${theme.colors?.root.accent})`,
                  }"
                />
              </div>
            </Label>
          </div>
        </RadioGroup>
      </div>

      <DialogFooter
        class="flex flex-row items-center justify-end space-x-2 pt-4"
      >
        <Button variant="secondary" size="sm" @click="() => (isOpen = false)">
          Cancel
        </Button>

        <Button variant="default" size="sm" @click="handleSave">Save</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
