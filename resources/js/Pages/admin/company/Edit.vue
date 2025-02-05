<script setup>
// import { faEdit } from '@fortawesome/pro-duotone-svg-icons'
import { faImageSlash, faTrashAlt } from '@fortawesome/pro-duotone-svg-icons'
import { faCircle } from '@fortawesome/pro-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Head, Link, router } from '@inertiajs/vue3'
import { useQueryClient } from '@tanstack/vue-query'
import { useForm } from 'vee-validate'
import { watch } from 'vue'
import * as yup from 'yup'

import CompanyDestroyDialog from '@/components/feature/company/CompanyDestroyDialog.vue'
import CompanySetImageAsset from '@/components/feature/company/CompanySetImageAsset.vue'
import ImageDestroyDialog from '@/components/feature/image/ImageDestroyDialog.vue'
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
import { Label } from '@/components/ui/label'
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
import { useCompanyUpdateMutation } from '@/composables/mutations/company'
import { useCompanyQuery } from '@/composables/queries/company'
import { useThemesQuery } from '@/composables/queries/theme'

const props = defineProps({
  companyInitialValues: {
    type: Object,
    required: true,
  },
})

const queryClient = useQueryClient()

const { data: company, isError } = useCompanyQuery({
  id: props.companyInitialValues.id,

  config: {
    initialData: props.companyInitialValues,
  },
})

const { data: themes } = useThemesQuery()

const updateCompanyFormSchema = yup.object({
  name: yup.string().min(1).required(),
  pipeline_company_id: yup.number().min(1).required(),
  logo_image_id: yup.number().nullable(),
  website: yup.string().nullable(),
  phone: yup.string().nullable(),
  email: yup.string().nullable(),
  theme_id: yup.number().required(),
  enable_map: yup.boolean().required(),
})

const { isFieldDirty, handleSubmit, resetForm } = useForm({
  validationSchema: updateCompanyFormSchema,
  initialValues: {
    name: props.companyInitialValues.name,
    pipeline_company_id: props.companyInitialValues.pipeline_company_id,
    website: props.companyInitialValues.website,
    phone: props.companyInitialValues.phone,
    email: props.companyInitialValues.email,
    theme_id: `${props.companyInitialValues.theme_id}`,
    enable_map: Boolean(props.companyInitialValues.enable_map),
    logo_image_id: props.companyInitialValues.logo?.id
      ? `${props.companyInitialValues.logo?.id}`
      : null,
  },
  keepValuesOnUnmount: true,
})

const { mutate: updateCompany } = useCompanyUpdateMutation({
  config: {
    onSuccess: async () => {
      await queryClient.invalidateQueries({
        queryKey: [`companies`],
      })

      router.visit(route(`admin.dashboard`))
    },
  },
})

const onValidForm = (values) => {
  updateCompany({ companyId: company?.id, formData: values })
}

const onInvalidForm = ({ values, errors, results }) => {
  console.log(values)
  console.log(errors)
  console.log(results)
}

const submitForm = () => {
  handleSubmit(onValidForm, onInvalidForm)()
}

watch(
  () => company,
  (newCompany) => {
    if (newCompany) {
      resetForm({
        values: {
          name: newCompany.name,
          pipeline_company_id: newCompany.pipeline_company_id,
          website: newCompany.website,
          phone: newCompany.phone,
          email: newCompany.email,
          theme_id: `${newCompany.theme_id}`,
          enable_map: Boolean(newCompany.enable_map),
          logo_image_id: `${newCompany.logo?.id}`,
        },
      })
    }
  },
)
</script>

<template>
  <div></div>
  <Head :title="`${company?.name} - Manage Company`" />

  <DefaultLayout>
    <div v-if="company && !isError" class="group relative h-72">
      <div
        class="absolute left-8 top-40 mb-4 flex flex-col items-stretch justify-start space-y-4"
      >
        <div
          class="relative flex aspect-square h-40 w-40 flex-row items-center justify-center overflow-hidden rounded-lg border border-border bg-card p-4 shadow-lg"
        >
          <img
            v-if="company.logo?.file_path"
            :src="`/${company.logo?.file_path}`"
            :alt="company.logo?.name"
          />

          <div
            v-else
            class="absolute left-0 top-0 flex h-full w-full flex-row items-center justify-center overflow-hidden rounded-lg bg-muted"
          >
            <FontAwesomeIcon
              class="text-4xl text-muted-foreground"
              :icon="faImageSlash"
              fixed-width
            />
          </div>
        </div>

        <CompanySetImageAsset :company="company" type="logo">
          {{ company.logo?.file_path ? `Edit` : `Add` }} Logo
        </CompanySetImageAsset>
      </div>

      <div
        class="absolute right-2 top-2 flex flex-row items-center justify-end space-x-2"
      >
        <ImageDestroyDialog
          v-if="company.banner?.file_path"
          :image="company.banner"
        >
          <FontAwesomeIcon :icon="faTrashAlt" fixed-width />
        </ImageDestroyDialog>

        <CompanySetImageAsset :company="company" type="banner">
          {{ company.banner?.file_path ? `Edit` : `Add` }} Banner
        </CompanySetImageAsset>
      </div>

      <div
        v-if="company.banner?.file_path"
        class="absolute left-0 top-0 -z-10 h-full w-full overflow-hidden rounded-lg opacity-65 transition-opacity duration-500 ease-in-out group-hover:opacity-100"
      >
        <img
          src="https://jayco.com/uploads/sections/1-bg-Homepage-Picture-2023-B.jpg"
          :alt="company.banner?.name"
          class="h-full w-full object-cover"
        />
      </div>

      <div
        v-else
        class="absolute left-0 top-0 -z-10 flex h-full w-full flex-row items-center justify-center overflow-hidden rounded-lg bg-muted"
      >
        <FontAwesomeIcon
          class="text-4xl text-muted-foreground"
          :icon="faImageSlash"
          fixed-width
        />
      </div>
    </div>

    <section v-if="company && !isError" class="mt-32">
      <form
        :id="`editCompanyForm_${company.uuid}`"
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
              <Input type="number" placeholder="123" v-bind="componentField" />
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
      </form>

      <div class="mx-2 mt-4 md:mx-0">
        <Label>Footer</Label>

        <div class="relative mt-2 h-72">
          <div
            class="absolute right-2 top-2 flex flex-row items-center justify-end space-x-2"
          >
            <ImageDestroyDialog
              v-if="company.footer?.file_path"
              :image="company.footer"
            >
              <FontAwesomeIcon :icon="faTrashAlt" fixed-width />
            </ImageDestroyDialog>

            <CompanySetImageAsset :company="company" type="footer">
              {{ company.footer?.file_path ? `Edit` : `Add` }} Footer
            </CompanySetImageAsset>
          </div>

          <div
            v-if="company.footer?.file_path"
            class="absolute left-0 top-0 -z-10 h-full w-full overflow-hidden rounded-lg"
          >
            <img
              src="https://jayco.com/uploads/sections/1-bg-Homepage-Picture-2023-B.jpg"
              :alt="company.footer.name"
              class="h-full w-full object-cover"
            />
          </div>

          <div
            v-else
            class="absolute left-0 top-0 -z-10 flex h-full w-full flex-row items-center justify-center overflow-hidden rounded-lg bg-muted"
          >
            <FontAwesomeIcon
              class="text-4xl text-muted-foreground"
              :icon="faImageSlash"
              fixed-width
            />
          </div>
        </div>
      </div>
    </section>

    <div
      class="fixed bottom-0 left-0 right-0 border-t border-t-border/70 bg-background/70 px-4 py-2 shadow-[0_-12px_25px_-12px_rgb(0_0_0_/_0.17)] backdrop-blur-lg"
    >
      <div
        class="mx-auto flex w-full max-w-3xl flex-row items-center justify-end space-x-2 py-2"
      >
        <div class="mr-auto">
          <CompanyDestroyDialog :company="company" />
        </div>

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
    </div>
  </DefaultLayout>
</template>
