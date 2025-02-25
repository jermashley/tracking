<script setup>
import { usePage } from '@inertiajs/vue3'
import { onMounted, onUnmounted, ref } from 'vue'

import UserDropdown from '@/components/feature/user/navigation/UserDropdown.vue'
import { imageAssetUrl } from '@/composables/hooks/disks'

const {
  auth: { user },
  company,
} = usePage().props

defineProps({
  useAppName: {
    type: Boolean,
    default: false,
  },
  userDropdown: {
    type: Boolean,
    default: false,
  },
  useLogo: {
    type: Boolean,
    default: true,
  },
})

// Reactive reference to track scroll position
const scrollY = ref(0)

const handleScroll = () => {
  scrollY.value = window.scrollY
}

onMounted(() => {
  window.addEventListener(`scroll`, handleScroll)
})

onUnmounted(() => {
  window.removeEventListener(`scroll`, handleScroll)
})
</script>

<template>
  <header
    class="sticky top-0 z-50 w-full border-b border-b-border/70 bg-background/70 backdrop-blur-lg"
  >
    <nav
      class="relative mx-auto flex h-16 w-full max-w-3xl flex-row items-center justify-center px-6 lg:px-0"
    >
      <div
        v-if="useLogo"
        class="flex flex-col items-center justify-center"
        :class="{ scaled: scrollY > 0, logo: scrollY <= 0 }"
      >
        <img
          v-if="company && company?.logo"
          :src="imageAssetUrl({ filePath: company.logo?.file_path })"
          :alt="company.logo?.name ?? `Company logo`"
          class="h-full w-auto object-contain"
        />

        <img
          v-else
          :src="imageAssetUrl({ filePath: `images/FW_Logo_Full_Color.png` })"
          alt="Flat World Global Solutions Logo"
          class="h-full w-auto object-contain"
        />
      </div>

      <div
        v-if="userDropdown"
        class="ml-auto flex flex-row items-center justify-end space-x-4"
      >
        <p
          class="whitespace-nowrap text-lg font-extrabold text-zinc-700 dark:text-zinc-200"
        >
          {{ useAppName ? $page.props.app.name : company?.name }}
        </p>

        <UserDropdown v-if="user" />
      </div>
    </nav>
  </header>
</template>
<style scoped>
.logo {
  @apply h-full w-fit translate-y-1/2 scale-[175%] transform rounded-lg border border-border/50 bg-background px-6 py-3 shadow-lg backdrop-blur-lg transition-all duration-300 ease-in-out;
}

.scaled {
  @apply h-full w-fit translate-y-1/2 scale-[125%] transform rounded-lg border border-border/50 bg-background px-6 py-4 transition-all duration-300 ease-in-out;
}
</style>
