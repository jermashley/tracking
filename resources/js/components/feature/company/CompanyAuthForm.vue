<script setup>
import { useQueryClient } from '@tanstack/vue-query'
import { Eye, EyeOff } from 'lucide-vue-next'
import { useForm, useIsFormDirty } from 'vee-validate'
import { computed, ref, watch } from 'vue'
import * as yup from 'yup'

import CompanyApiTokenDeleteDialog from '@/components/feature/company/CompanyApiTokenDeleteDialog.vue'
import { Button } from '@/components/ui/button'
import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { useToast } from '@/components/ui/toast'
import { useCompanyApiTokenMutation } from '@/composables/mutations/company'

const props = defineProps({
  company: {
    type: Object,
    required: true,
  },
})

const queryClient = useQueryClient()
const { toast } = useToast()

const apiTokenSchema = yup.object({
  api_token: yup.string().required(`API token is required`),
})

const { handleSubmit, resetForm, isFieldDirty } = useForm({
  validationSchema: apiTokenSchema,
  initialValues: {
    api_token: ``,
  },
  keepValuesOnUnmount: true,
})

const isFormDirty = useIsFormDirty()

const { mutate: updateCompanyApiToken, isPending: updateCompanyIsPending } =
  useCompanyApiTokenMutation({
    config: {
      onSuccess: async () => {
        await queryClient.invalidateQueries({ queryKey: [`companies`] })
        toast({
          title: `API Token Saved`,
          description: `The API token has been successfully saved.`,
          duration: 5000,
        })
      },

      onError: async (error) => {
        toast({
          title: `Error Saving API Token`,
          description:
            error.response.data.error ||
            `An error occurred while saving the API token.`,
          variant: `destructive`,
        })
      },
    },
  })

const onValidSubmit = (values) => {
  updateCompanyApiToken({
    companyId: props.company?.id,
    apiToken: values.api_token,
  })
}

const onInvalidSubmit = ({ values, errors }) => {
  console.error(`Invalid API Token Submission:`, { values, errors })
}

const submitForm = () => {
  handleSubmit(onValidSubmit, onInvalidSubmit)()
}

watch(
  () => [props.company, props.company.api_token],
  () => {
    resetForm({ values: { api_token: `` } })
    refApiTokenInput.value = props.company?.api_token?.api_token ?? null
    console.log(props.company)
    hasApiToken.value = props.company.api_token !== null
  },
)

const showPassword = ref(false)
const refApiTokenInput = ref(props.company?.api_token?.api_token ?? null)

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}

const hasApiToken = ref(props.company?.api_token)

const isTokenValid = computed(
  () => props.company?.api_token && props.company?.api_token?.is_valid,
)
</script>

<template>
  <h2 class="mt-8 text-lg font-semibold text-foreground">API Token</h2>
  <div
    v-if="hasApiToken"
    class="mt-4 flex w-full flex-col space-y-4 rounded-lg border border-border p-4"
  >
    <div class="flex items-center justify-between">
      <div class="text-sm font-medium">
        <span>Status: </span>
        <span
          :class="{
            'text-green-600': isTokenValid,
            'text-red-600': !isTokenValid,
          }"
        >
          {{ isTokenValid ? 'Valid' : 'Invalid' }}
        </span>
      </div>

      <CompanyApiTokenDeleteDialog :company="company" />
    </div>

    <div class="relative">
      <Input
        :type="showPassword ? 'text' : 'password'"
        :default-value="refApiTokenInput"
        readonly
      />
      <Button
        variant="ghost"
        type="button"
        class="absolute right-3 top-1/2 -translate-y-1/2"
        @click="togglePasswordVisibility"
      >
        <Eye v-if="!showPassword" class="h-5 w-5 text-gray-500" />
        <EyeOff v-else class="h-5 w-5 text-gray-500" />
      </Button>
    </div>
  </div>

  <form
    v-else
    class="mt-4 flex w-full flex-col space-y-4 rounded-lg border border-border p-4"
    @submit.prevent="submitForm"
  >
    <FormField
      v-slot="{ componentField }"
      name="api_token"
      :validate-on-blur="!isFieldDirty"
    >
      <FormItem>
        <FormLabel>API Token</FormLabel>

        <FormControl>
          <Input
            type="password"
            placeholder="Enter API token"
            v-bind="componentField"
            :disabled="updateCompanyIsPending"
          />
        </FormControl>

        <FormDescription>
          Provide the API token associated with the company.
        </FormDescription>
      </FormItem>
    </FormField>

    <div class="flex justify-end space-x-2 pt-4">
      <Button
        variant="default"
        size="sm"
        type="submit"
        :disabled="updateCompanyIsPending || !isFormDirty"
      >
        Save API Token
      </Button>
    </div>
  </form>
</template>
