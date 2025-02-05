<script setup>
import { faImage } from '@fortawesome/pro-duotone-svg-icons'
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
import { useCompanySetImageAssetMutation } from '@/composables/mutations/company'
import { useImageStoreMutation } from '@/composables/mutations/image'
import { imageTypes } from '@/lib/types'

const props = defineProps({
  company: {
    type: Object,
    required: true,
  },
  type: {
    type: String,
    required: true,
    validator(value) {
      return Object.values(imageTypes).includes(value)
    },
  },
  iconOnly: {
    type: Boolean,
    default: false,
  },
})

const isOpen = ref(false)

const queryClient = useQueryClient()

const newLogoFormSchema = yup.object({
  name: yup.string().min(1).required(),
  image: yup.string().required(),
})

const { resetForm, isFieldDirty, handleSubmit } = useForm({
  validationSchema: newLogoFormSchema,
})

const { mutate: setImageAsset } = useCompanySetImageAssetMutation({
  config: {
    onSuccess: async () => {
      await queryClient.invalidateQueries({
        queryKey: [`companies`, props.company.id],
        exact: true,
      })

      await queryClient.invalidateQueries({
        queryKey: [`companies`],
        exact: true,
      })
    },
  },
})

const { mutate: createLogo } = useImageStoreMutation({
  config: {
    onSuccess: (data) => {
      resetForm()

      setImageAsset({
        companyId: props.company.id,
        imageId: data.id,
        type: props.type,
      })

      isOpen.value = false
    },
  },
})

const onValidForm = (values) => {
  createLogo({
    formData: {
      ...values,
      image_type_id: 1,
    },
  })
}

const onInvalidForm = ({ values, errors, results }) => {
  console.error(values)
  console.error(errors)
  console.error(results)
}

const submitForm = () => {
  handleSubmit(onValidForm, onInvalidForm)()
}

const cancelDialog = () => {
  isOpen.value = false
  resetForm()
}
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogTrigger as-child>
      <Button
        variant="outline"
        size="sm"
        :class="{
          'w-full': !iconOnly,
          'w-auto': iconOnly,
        }"
      >
        <FontAwesomeIcon
          :class="{
            'mr-2': !iconOnly,
          }"
          :icon="faImage"
          fixed-width
        />

        <span v-if="!iconOnly">
          <slot />
        </span>
      </Button>
    </DialogTrigger>

    <DialogContent class="max-h-[85dvh] grid-rows-[auto_minmax(0,1fr)_auto]">
      <DialogHeader>
        <DialogTitle>Add New Logo</DialogTitle>

        <VisuallyHidden as-child>
          <DialogDescription>A dialog to add a logo.</DialogDescription>
        </VisuallyHidden>
      </DialogHeader>

      <form
        id="newLogoForm"
        class="flex w-full flex-col space-y-4 overflow-y-auto px-2"
        @submit="submitForm"
      >
        <FormField
          v-slot="{ componentField }"
          name="name"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel> Name </FormLabel>

            <FormControl>
              <Input
                type="text"
                placeholder="ACME Inc. Logo"
                v-bind="componentField"
              />
            </FormControl>

            <FormDescription>
              The name of the logo image file.
            </FormDescription>
          </FormItem>
        </FormField>

        <FormField
          v-slot="{ handleChange }"
          name="image"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>Image File</FormLabel>

            <FormControl>
              <Input
                accept="image/*"
                type="file"
                @change="
                  (event) => {
                    console.log(event.target.files[0])
                    handleChange(event.target.files[0])
                  }
                "
              />
            </FormControl>

            <FormDescription> The image file. </FormDescription>
          </FormItem>
        </FormField>
      </form>

      <DialogFooter
        class="flex flex-row items-center justify-end space-x-2 pt-4"
      >
        <Button variant="secondary" size="sm" @click="cancelDialog">
          Cancel
        </Button>

        <Button
          type="button"
          variant="default"
          size="sm"
          class=""
          @click="submitForm"
        >
          Save
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
