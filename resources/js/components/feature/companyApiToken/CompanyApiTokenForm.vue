<script setup>
import {
  faBadgeCheck,
  faClipboard,
  faTriangleExclamation,
} from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { useQueryClient } from '@tanstack/vue-query'
import { useClipboard } from '@vueuse/core'
import { Eye, EyeOff } from 'lucide-vue-next'
import { useForm, useIsFormDirty } from 'vee-validate'
import { computed, ref, watch } from 'vue'
import * as yup from 'yup'

import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { useToast } from '@/components/ui/toast'
import { useCompanyApiTokenStoreMutation } from '@/composables/mutations/company'

import CompanyApiTokenDeleteDialog from './CompanyApiTokenDeleteDialog.vue'

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
  quote_id: yup.number().required(`Quote ID is required`),
})

const { handleSubmit, resetForm, isFieldDirty } = useForm({
  validationSchema: apiTokenSchema,
  initialValues: {
    api_token: null,
    quote_id: null,
  },
  keepValuesOnUnmount: true,
})

const isFormDirty = useIsFormDirty()

const { mutate: updateCompanyApiToken, isPending: companyApiTokenIsPending } =
  useCompanyApiTokenStoreMutation({
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
    quoteId: values.quote_id,
  })
}

const onInvalidSubmit = ({ values, errors }) => {
  console.error(`Invalid API Token Submission:`, { values, errors })
}

const submitForm = () => {
  handleSubmit(onValidSubmit, onInvalidSubmit)()
}

const showPassword = ref(false)
const refApiTokenInput = ref(props.company?.api_token?.api_token ?? null)

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}

const hasApiToken = ref(props.company?.api_token)

const tokenIsValid = computed(() => props.company?.api_token?.is_valid)

watch(
  () => [props.company, props.company.api_token],
  () => {
    resetForm({ values: { api_token: `` } })

    refApiTokenInput.value = props.company?.api_token?.api_token ?? null

    hasApiToken.value = props.company.api_token !== null
  },
)

const apiTokenClipboard = useClipboard()
</script>

<template>
  <Card class="mt-8 w-full">
    <CardHeader>
      <CardTitle>Pipeline Authentication</CardTitle>
    </CardHeader>

    <CardContent v-if="hasApiToken">
      <div
        class="relative flex w-full flex-row items-center justify-start space-x-2"
      >
        <p class="w-full">
          <span class="font-mono text-sm">{{ refApiTokenInput }}</span>
        </p>

        <FontAwesomeIcon
          v-if="tokenIsValid"
          class="text-green-600"
          :icon="faBadgeCheck"
          fixed-width
        />

        <FontAwesomeIcon
          v-else
          class="text-red-600"
          :icon="faTriangleExclamation"
          fixed-width
        />
      </div>
    </CardContent>

    <CardContent v-else>
      <form
        id="companyApiTokenForm"
        class="mt-4 flex w-full flex-col space-y-4"
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
                type="text"
                placeholder="Enter API token"
                v-bind="componentField"
                :disabled="companyApiTokenIsPending"
              />
            </FormControl>

            <FormDescription>
              API token associated with
              <strong> {{ company.name }} </strong>.

              <br />

              Pipeline company ID:
              <strong> {{ company.pipeline_company_id }} </strong>.
            </FormDescription>
          </FormItem>
        </FormField>

        <FormField
          v-slot="{ componentField }"
          name="quote_id"
          :validate-on-blur="!isFieldDirty"
        >
          <FormItem>
            <FormLabel>Quote ID</FormLabel>

            <FormControl>
              <Input
                type="number"
                placeholder="Quote ID"
                v-bind="componentField"
                :disabled="companyApiTokenIsPending"
              />
            </FormControl>

            <FormDescription>
              Quote ID associated with
              <strong> {{ company.name }} </strong>.
            </FormDescription>
          </FormItem>
        </FormField>
      </form>
    </CardContent>

    <CardFooter>
      <div class="flex w-full justify-end space-x-2 pt-4">
        <CompanyApiTokenDeleteDialog v-if="hasApiToken" :company="company" />

        <Button
          v-else
          variant="default"
          size="sm"
          type="submit"
          form="companyApiTokenForm"
          :disabled="companyApiTokenIsPending || !isFormDirty"
        >
          Save API Token
        </Button>
      </div>
    </CardFooter>
  </Card>
</template>
