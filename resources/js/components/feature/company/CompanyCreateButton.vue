<script setup>
import { faPlus } from '@fortawesome/pro-duotone-svg-icons'
import { faCircle } from '@fortawesome/pro-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useQueryClient } from '@tanstack/vue-query'
import { VisuallyHidden } from 'radix-vue'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import * as yup from 'yup'

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
import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { Switch } from '@/components/ui/switch'
import { useCompanyCreateMutation } from '@/composables/mutations/company'
import { useThemesQuery } from '@/composables/queries/theme'

const isOpen = ref(false)

const queryClient = useQueryClient()

const { data: themes } = useThemesQuery()

const newCompanyFormSchema = yup.object({
  name: yup.string().min(1).required(),
  pipeline_company_id: yup.number().min(1).required(),
  // logo: yup.string().nullable(),
  website: yup.string().nullable(),
  phone: yup.string().nullable(),
  email: yup.string().nullable(),
  theme_id: yup.number().required(),
  enable_map: yup.boolean().required(),
})

const { resetForm, isFieldDirty, handleSubmit } = useForm({
  validationSchema: newCompanyFormSchema,
  initialValues: {
    name: ``,
    pipeline_company_id: null,
    // logo: ``,
    website: ``,
    phone: ``,
    email: ``,
    theme_id: null,
    enable_map: false,
  },
})

const { mutate: createCompany } = useCompanyCreateMutation({
  config: {
    onSuccess: () => {
      queryClient.invalidateQueries(`companies`)
      resetForm()
      isOpen.value = false
    },
  },
})

const onValidForm = (values) => {
  console.log(values)
  createCompany({ formData: values })
}

const onInvalidForm = ({ values, errors, results }) => {
  console.log(values)
  console.log(errors)
  console.log(results)
}

const submitForm = () => {
  console.log(`submitting form`)
  handleSubmit(onValidForm, onInvalidForm)()
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button variant="default" size="sm">
        <FontAwesomeIcon :icon="faPlus" class="mr-2" fixed-width />

        <span>Add Company</span>
      </Button>
    </DialogTrigger>

    <DialogContent class="max-h-[85dvh] grid-rows-[auto_minmax(0,1fr)_auto]">
      <VisuallyHidden as-child>
        <DialogDescription>A dialog to add a company.</DialogDescription>
      </VisuallyHidden>

      <DialogHeader>
        <DialogTitle>Add Company</DialogTitle>
      </DialogHeader>

      <form
        id="newCompanyForm"
        class="flex w-full flex-col space-y-4 overflow-y-auto px-2"
        @submit="submitForm"
      >
        <FormField
          v-slot="{ componentField }"
          name="name"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>Name</FormLabel>

            <FormControl>
              <Input
                type="text"
                placeholder="ACME Inc."
                v-bind="componentField"
              />
            </FormControl>

            <FormDescription>The name of the company.</FormDescription>
          </FormItem>
        </FormField>

        <FormField
          v-slot="{ componentField }"
          name="pipeline_company_id"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>Pipeline Company ID</FormLabel>

            <FormControl>
              <Input type="number" placeholder="123" v-bind="componentField" />
            </FormControl>

            <FormDescription>
              The ID of the company in Pipeline.
            </FormDescription>
          </FormItem>
        </FormField>

        <!-- <FormField
          v-slot="{ componentField }"
          name="logo"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>Logo</FormLabel>

            <FormControl>
              <Input type="file" v-bind="componentField" />
            </FormControl>

            <FormDescription>
              Company logo. Must be a PNG, JPG, or SVG file.
            </FormDescription>
          </FormItem>
        </FormField> -->

        <FormField
          v-slot="{ componentField }"
          name="website"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>Website</FormLabel>

            <FormControl>
              <Input
                type="text"
                placeholder="https://acme.com"
                v-bind="componentField"
              />
            </FormControl>

            <FormDescription> The company's website URL. </FormDescription>
          </FormItem>
        </FormField>

        <FormField
          v-slot="{ componentField }"
          name="phone"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>Phone Number</FormLabel>

            <FormControl>
              <Input
                type="tel"
                placeholder="(123) 456-7890"
                v-bind="componentField"
              />
            </FormControl>

            <FormDescription> The company's phone number. </FormDescription>
          </FormItem>
        </FormField>

        <FormField
          v-slot="{ componentField }"
          name="email"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>E-mail</FormLabel>

            <FormControl>
              <Input
                type="email"
                placeholder="info@acme.com"
                v-bind="componentField"
              />
            </FormControl>

            <FormDescription> The company's email address. </FormDescription>
          </FormItem>
        </FormField>

        <FormField
          v-slot="{ componentField }"
          name="theme_id"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>Theme</FormLabel>

            <Select v-bind="componentField">
              <FormControl>
                <SelectTrigger class="w-full">
                  <SelectValue placeholder="Select a theme" />
                </SelectTrigger>
              </FormControl>

              <SelectContent>
                <SelectGroup>
                  <SelectLabel>Themes</SelectLabel>

                  <SelectItem
                    v-for="theme in themes"
                    :key="theme.uuid"
                    :value="`${theme.id}`"
                  >
                    <div class="flex flex-row items-center justify-between">
                      <div
                        class="mr-2 flex flex-row items-center justify-center"
                      >
                        <FontAwesomeIcon
                          :icon="faCircle"
                          class="z-10 text-lg"
                          fixed-width
                          :style="{
                            color: `hsl(${theme.colors.root.primary})`,
                          }"
                        />

                        <FontAwesomeIcon
                          :icon="faCircle"
                          class="-ml-3 text-lg"
                          fixed-width
                          :style="{
                            color: `hsl(${theme.colors.root.accent})`,
                          }"
                        />
                      </div>

                      <span>{{ theme.name }}</span>
                    </div>
                  </SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>

            <FormDescription> The company's email address. </FormDescription>
          </FormItem>
        </FormField>

        <FormField v-slot="{ value, handleChange }" name="enable_map">
          <FormItem
            class="flex flex-row items-center justify-between rounded-lg border p-4"
          >
            <div class="space-y-0.5">
              <FormLabel class="text-base">Enable Map</FormLabel>

              <FormDescription>
                Enable the tracking/route map.
              </FormDescription>
            </div>

            <FormControl>
              <Switch :checked="value" @update:checked="handleChange" />
            </FormControl>
          </FormItem>
        </FormField>
      </form>

      <DialogFooter
        class="flex flex-row items-center justify-end space-x-2 pt-4"
      >
        <Button variant="secondary" size="sm" @click="() => (isOpen = false)">
          Cancel
        </Button>

        <Button
          variant="default"
          size="sm"
          type="button"
          class=""
          @click="submitForm"
        >
          Save
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
