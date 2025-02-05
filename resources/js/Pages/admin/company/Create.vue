<script setup>
// import { faEdit } from '@fortawesome/pro-duotone-svg-icons'
import { faCircle } from '@fortawesome/pro-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Head, Link, router } from '@inertiajs/vue3'
import { useQueryClient } from '@tanstack/vue-query'
import { useForm } from 'vee-validate'
import * as yup from 'yup'

import DefaultLayout from '@/components/layout/page/DefaultLayout.vue'
import { Button } from '@/components/ui/button'
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
// import { useImagesQuery } from '@/composables/queries/image'
import { useThemesQuery } from '@/composables/queries/theme'

const queryClient = useQueryClient()

const { data: themes } = useThemesQuery()

// const { data: images } = useImagesQuery({
//   imageType: `logos`,
//   imageTypeId: 1,
// })

const newCompanyFormSchema = yup.object({
  name: yup.string().min(1).required(),
  pipeline_company_id: yup.number().min(1).required(),
  website: yup.string().nullable(),
  phone: yup.string().nullable(),
  email: yup.string().nullable(),
  theme_id: yup.number().required(),
  enable_map: yup.boolean().required(),
  logo_image_id: yup.number().nullable(),
})

const { resetForm, isFieldDirty, handleSubmit } = useForm({
  validationSchema: newCompanyFormSchema,
  initialValues: {
    name: ``,
    pipeline_company_id: null,
    website: ``,
    phone: ``,
    email: ``,
    theme_id: null,
    enable_map: false,
    logo_image_id: null,
  },
})

const { mutate: createCompany } = useCompanyCreateMutation({
  config: {
    onSuccess: async (data) => {
      resetForm()

      await queryClient.invalidateQueries({
        queryKey: [`companies`],
      })

      router.visit(route(`admin.company.show`, data.uuid))
    },
  },
})

const onValidForm = (values) => {
  createCompany({
    formData: values,
  })
}

const onInvalidForm = ({ values, errors, results }) => {
  console.log(values)
  console.log(errors)
  console.log(results)
}

const submitForm = () => {
  handleSubmit(onValidForm, onInvalidForm)()
}
</script>

<template>
  <Head title="Create Company`" />

  <DefaultLayout>
    <div class="">
      <h1 class="text-4xl font-bold">Create Company</h1>

      <p class="">Create a new company</p>

      <section class="mt-8">
        <form
          id="newCompanyForm"
          class="flex w-full flex-col space-y-4 px-2 md:px-0"
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
                <Input
                  type="number"
                  placeholder="123"
                  v-bind="componentField"
                />
              </FormControl>

              <FormDescription>
                The ID of the company in Pipeline.
              </FormDescription>
            </FormItem>
          </FormField>

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

              <FormDescription> The company's theme. </FormDescription>
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

          <!-- <FormField
            v-slot="{ componentField }"
            name="logo_image_id"
            :validate-on-blur="!isFieldDirty"
          >
            <FormItem>
              <FormLabel>Logo</FormLabel>

              <div class="flex flex-row items-center justify-start space-x-2">
                <Select v-bind="componentField">
                  <FormControl>
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Select a logo" />
                    </SelectTrigger>
                  </FormControl>
                  <SelectContent>
                    <SelectGroup>
                      <SelectLabel>Logo</SelectLabel>

                      <SelectItem
                        v-for="image in images"
                        :key="image.uuid"
                        :value="`${image.id}`"
                      >
                        <div class="flex flex-row items-center justify-between">
                          <div
                            class="mr-2 flex flex-row items-center justify-center"
                          >
                            <div class="relative aspect-square w-8">
                              <img
                                :src="`/${image.file_path}`"
                                class="absolute left-0 top-0 block h-full w-full scale-90 transform object-contain transition-all duration-300 group-hover:scale-95"
                              />
                            </div>
                          </div>

                          <span>{{ image.name }}</span>
                        </div>
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>

                <LogoStoreDialog icon-only />
              </div>

              <FormDescription>The company's logo.</FormDescription>
            </FormItem>
          </FormField> -->
        </form>

        <div class="mt-8 flex flex-row items-center justify-end space-x-2">
          <Button variant="secondary" size="sm">
            <Link :href="route(`admin.dashboard`)">Cancel</Link>
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
        </div>
      </section>
    </div>
  </DefaultLayout>
</template>
