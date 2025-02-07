<script setup>
import { imageAssetUrl } from '@/composables/hooks/disks'
import { useCompanyTheme } from '@/composables/hooks/theme'

import Footer from '../footer/Footer.vue'
import Navbar from '../navigation/Navbar.vue'

useCompanyTheme()

defineProps({
  bannerFilePath: {
    type: String,
    required: false,
    default: null,
  },
  footerFilePath: {
    type: String,
    required: false,
    default: null,
  },
})
</script>

<template>
  <div
    class="relative grid min-h-screen items-start bg-background/0"
    :class="{
      'grid-rows-[auto,1fr,auto,auto]': bannerFilePath,
      'grid-rows-[auto,auto,auto]': !bannerFilePath,
    }"
  >
    <Navbar />

    <div
      v-if="bannerFilePath"
      class="relative -z-10 h-[50vh] w-full overflow-hidden"
    >
      <img
        :src="imageAssetUrl({ filePath: bannerFilePath })"
        class="mx-auto h-full w-full max-w-7xl object-cover"
        alt=""
      />

      <img
        :src="imageAssetUrl({ filePath: bannerFilePath })"
        class="absolute bottom-0 left-0 right-0 top-0 -z-10 h-[120%] w-[120%] object-cover opacity-75 blur-2xl"
        alt=""
      />
    </div>

    <div
      class="mx-auto mb-8 w-auto max-w-3xl rounded-lg bg-background px-6 py-4"
      :class="{
        'mt-8 lg:-mt-24': bannerFilePath,
        'mt-32 lg:mt-32': !bannerFilePath,
      }"
    >
      <main class="w-full">
        <slot />
      </main>

      <div
        v-if="footerFilePath"
        class="mx-auto mt-8 w-full max-w-3xl overflow-hidden rounded-lg shadow-xl"
      >
        <img
          :src="imageAssetUrl({ filePath: footerFilePath })"
          class="w-full object-cover"
          alt=""
        />
      </div>
    </div>

    <Footer />
  </div>
</template>
