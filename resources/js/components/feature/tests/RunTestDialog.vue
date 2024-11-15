<script setup>
import { faRocket } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useQueryClient } from '@tanstack/vue-query'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import * as z from 'zod'

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
import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
} from '@/components/ui/form'
import FormLabel from '@/components/ui/form/FormLabel.vue'
import { Input } from '@/components/ui/input'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { useStoreTestRunMutation } from '@/composables/mutations/testRun'

defineProps({
  buttonSize: {
    type: String,
    default: `sm`,
  },
})

const isOpen = ref(false)

const queryClient = useQueryClient()

const storeTestRunFormSchema = toTypedSchema(
  z.object({
    key: z.string(),
    type: z.enum([`all`, `api`, `ui`]),
  }),
)

const storeTestRunForm = useForm({
  validationSchema: storeTestRunFormSchema,
  initialValues: {
    key: ``,
    type: `all`,
  },
})

const storeTestRunMutation = useStoreTestRunMutation()

const handleSubmit = storeTestRunForm.handleSubmit((values) => {
  storeTestRunMutation.mutate(
    {
      formData: values,
    },
    {
      onSuccess: () => {
        storeTestRunForm.resetForm()
        storeTestRunMutation.reset()
        queryClient.invalidateQueries([`testRuns`])
        isOpen.value = false
      },
      onError: () => {
        console.log(`was error`)
        storeTestRunForm.resetForm()
        storeTestRunMutation.reset()
      },
    },
  )
})
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button variant="outline" :size="buttonSize">
        <FontAwesomeIcon class="mr-2" :icon="faRocket" fixed-width />

        <span>Run Test</span>
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>Run Test</DialogTitle>

        <DialogDescription>
          Enter a key to run regression tests against.
        </DialogDescription>
      </DialogHeader>

      <form id="storeTestRunForm" @submit.prevent="handleSubmit">
        <FormField v-slot="{ componentField }" name="key">
          <FormItem class="flex flex-col space-y-2">
            <FormLabel>Key</FormLabel>

            <FormControl>
              <Input
                type="text"
                placeholder="SD2-1234"
                v-bind="componentField"
              />
            </FormControl>

            <FormDescription>
              This value helps build the endpoint that regression will be run
              against.
            </FormDescription>
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="type">
          <FormItem class="flex flex-col space-y-2">
            <FormLabel>Type</FormLabel>

            <FormControl>
              <Select v-bind="componentField">
                <SelectTrigger>
                  <SelectValue
                    placeholder="Select a verified email to display"
                  />
                </SelectTrigger>

                <SelectContent>
                  <SelectGroup>
                    <SelectItem value="all">All</SelectItem>
                    <SelectItem value="api">API</SelectItem>
                    <SelectItem value="ui">UI</SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
            </FormControl>
          </FormItem>
        </FormField>
      </form>

      <DialogFooter class="mt-6 flex flex-row items-center justify-end">
        <DialogClose as-child>
          <Button variant="destructive" size="sm">Cancel</Button>
        </DialogClose>

        <Button size="sm" type="submit" form="storeTestRunForm">Submit</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
