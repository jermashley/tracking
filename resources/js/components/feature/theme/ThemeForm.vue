<script setup>
import { router } from '@inertiajs/vue3'
import { useQueryClient } from '@tanstack/vue-query'
import { useForm, useIsFormDirty } from 'vee-validate'
import { computed, ref, watch } from 'vue'
import * as yup from 'yup'

import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group'
import { Slider } from '@/components/ui/slider'
import {
  useThemeCreateMutation,
  useThemeUpdateMutation,
} from '@/composables/mutations/theme'
import { cn } from '@/lib/utils'

const props = defineProps({
  theme: {
    type: Object,
    required: true,
  },
  heading: {
    type: String,
    default: `Theme Information`,
  },
})

const queryClient = useQueryClient()

const computedPrimaryHueValue = computed(() => {
  return props.theme.value?.colors?.root.primary.split(` `)[0]
})

const computedPrimarySaturationValue = computed(() => {
  return props.theme.value?.colors?.root.primary.split(` `)[1].replace(`%`, ``)
})

const computedPrimaryLightnessValue = computed(() => {
  return props.theme.value?.colors?.root.primary.split(` `)[2].replace(`%`, ``)
})

const computedAccentHueValue = computed(() => {
  return props.theme.value?.colors?.root.accent.split(` `)[0]
})

const computedAccentSaturationValue = computed(() => {
  return props.theme.value?.colors?.root.accent.split(` `)[1].replace(`%`, ``)
})

const computedAccentLightnessValue = computed(() => {
  return props.theme.value?.colors?.root.accent.split(` `)[2].replace(`%`, ``)
})

const primaryHueValue = ref([computedPrimaryHueValue.value])
const primarySaturationValue = ref([computedPrimarySaturationValue.value])
const primaryLightnessValue = ref([computedPrimaryLightnessValue.value])

const accentHueValue = ref([computedAccentHueValue.value])
const accentSaturationValue = ref([computedAccentSaturationValue.value])
const accentLightnessValue = ref([computedAccentLightnessValue.value])

const themeFormSchema = yup.object({
  name: yup.string().min(1).required(),
  primary_hue: yup.number().min(0).max(360).required(),
  primary_saturation: yup.number().min(0).max(100).required(),
  primary_lightness: yup.number().min(0).max(100).required(),
  accent_hue: yup.number().min(0).max(360).required(),
  accent_saturation: yup.number().min(0).max(100).required(),
  accent_lightness: yup.number().min(0).max(100).required(),
  derived_from: yup.string().oneOf([`primary`, `accent`]).required(),
})

const { isFieldDirty, handleSubmit, resetForm } = useForm({
  validationSchema: themeFormSchema,
  initialValues: {
    name: props.theme?.name,
    primary_hue: primaryHueValue,
    primary_saturation: primarySaturationValue,
    primary_lightness: primaryLightnessValue,
    accent_hue: accentHueValue,
    accent_saturation: accentSaturationValue,
    accent_lightness: accentLightnessValue,
    derived_from: props.theme?.derived_from,
  },
  keepValuesOnUnmount: true,
})

const isFormDirty = useIsFormDirty()

const { mutate: createTheme, isPending: createThemeIsPending } =
  useThemeCreateMutation({
    config: {
      onSuccess: (data) => {
        queryClient.invalidateQueries(`themes`)

        router.push(route(`admin.themes.show`), data.uuid)
      },
    },
  })

const { mutate: updateTheme, isPending: updateThemeIsPending } =
  useThemeUpdateMutation({
    config: {
      onSuccess: () => {
        queryClient.invalidateQueries(`themes`)

        router.push(route(`admin.themes.index`))
      },
    },
  })

const onValidForm = (values) => {
  if (props.theme) {
    updateTheme({
      id: props.theme.id,
      ...values,
    })
  } else {
    createTheme(values)
  }
}

const onInvalidForm = ({ values, errors, results }) => {
  console.error({ values, errors, results })
}

const submitForm = () => {
  handleSubmit(onValidForm, onInvalidForm)()
}

watch(
  () => props.theme,
  (newTheme) => {
    if (newTheme) {
      resetForm({
        values: {
          name: newTheme.name,
          primary_hue: primaryHueValue,
          primary_saturation: primarySaturationValue,
          primary_lightness: primaryLightnessValue,
          accent_hue: accentHueValue,
          accent_saturation: accentSaturationValue,
          accent_lightness: accentLightnessValue,
          derived_from: newTheme.derived_from,
        },
      })
    }
  },
)
</script>

<template>
  <form @submit.prevent="submitForm">
    <div class="flex flex-col justify-stretch space-y-4">
      <div
        class="flex w-full flex-row items-center justify-between space-x-8 rounded-lg border p-4"
      >
        <div class="w-full space-y-0.5">
          <Label class="text-base">Derive From</Label>

          <p class="text-sm text-muted-foreground">
            Select what color the accent should be derived from.
          </p>
        </div>

        <div>
          <RadioGroup
            default-value="primary"
            :orientation="`horizontal`"
            class="flex flex-row items-center justify-start space-x-4"
          >
            <div class="flex items-center space-x-2">
              <RadioGroupItem id="primary" value="primary" />

              <Label for="primary" class="text-base">Primary</Label>
            </div>

            <div class="flex items-center space-x-2">
              <RadioGroupItem id="accent" value="accent" />

              <Label for="accent" class="text-base">Accent</Label>
            </div>
          </RadioGroup>
        </div>
      </div>

      <div class="grid grid-cols-[auto,1fr] gap-x-20 rounded-lg border p-4">
        <div class="space-y-0.5 self-center">
          <Label class="text-base">Primary Color</Label>

          <p class="text-sm text-muted-foreground">
            The color of the primary color.
          </p>
        </div>

        <div class="grid grid-cols-[auto,1fr,auto] gap-x-8 gap-y-2">
          <Label class="self-center text-sm">Hue</Label>

          <Slider
            v-model="primaryHueValue"
            :max="360"
            :min="0"
            :class="cn('w-full', $attrs.class ?? ``)"
          />

          <Input
            v-model:model-value="primaryHueValue"
            class="w-20"
            type="number"
            :min="0"
            :max="360"
          />

          <Label class="self-center text-sm">Saturation</Label>

          <Slider
            v-model="primarySaturationValue"
            :max="100"
            :min="0"
            :class="cn('w-full', $attrs.class ?? ``)"
          />

          <Input
            v-model:model-value="primarySaturationValue"
            class="w-20"
            type="number"
            :min="0"
            :max="100"
          />

          <Label class="self-center text-sm">Lightness</Label>

          <Slider
            v-model="primaryLightnessValue"
            :max="100"
            :min="0"
            :class="cn('w-full', $attrs.class ?? ``)"
          />

          <Input
            v-model:model-value="primaryLightnessValue"
            class="w-20"
            type="number"
            :min="0"
            :max="100"
          />
        </div>
      </div>

      <div class="grid grid-cols-[auto,1fr] gap-x-20 rounded-lg border p-4">
        <div class="space-y-0.5 self-center">
          <Label class="text-base">Accent Color</Label>

          <p class="text-sm text-muted-foreground">
            The color of the accent theme.
          </p>
        </div>

        <div class="grid grid-cols-[auto,1fr,auto] gap-x-8 gap-y-2">
          <Label class="self-center text-sm">Hue</Label>

          <Slider
            v-model="accentHueValue"
            :max="360"
            :min="0"
            :class="cn('w-full', $attrs.class ?? ``)"
          />

          <Input
            v-model:model-value="accentHueValue"
            class="w-20"
            type="number"
            :min="0"
            :max="360"
          />

          <Label class="self-center text-sm">Saturation</Label>

          <Slider
            v-model="accentSaturationValue"
            :max="100"
            :min="0"
            :class="cn('w-full', $attrs.class ?? ``)"
          />

          <Input
            v-model:model-value="accentSaturationValue"
            class="w-20"
            type="number"
            :min="0"
            :max="100"
          />

          <Label class="self-center text-sm">Lightness</Label>

          <Slider
            v-model="accentLightnessValue"
            :max="100"
            :min="0"
            :class="cn('w-full', $attrs.class ?? ``)"
          />

          <Input
            v-model:model-value="accentLightnessValue"
            class="w-20"
            type="number"
            :min="0"
            :max="100"
          />
        </div>
      </div>
    </div>

    <section
      class="mt-12 flex flex-row items-center justify-center -space-x-12"
    >
      <div
        class="z-10 aspect-square h-24 w-24 rounded-full outline outline-[0.375rem] outline-background"
        :style="{
          backgroundColor: `hsl(${primaryHueValue}, ${primarySaturationValue}%, ${primaryLightnessValue}%)`,
        }"
      />

      <div
        class="-z-0 aspect-square h-24 w-24 rounded-full"
        :style="{
          backgroundColor: `hsl(${accentHueValue}, ${accentSaturationValue}%, ${accentLightnessValue}%)`,
        }"
      />
    </section>
  </form>
</template>
