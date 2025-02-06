<script setup>
import AuthenticatedNavbar from '../navigation/AuthenticatedNavbar.vue'
</script>

<template>
  <div class="grid min-h-screen grid-rows-[auto,1fr,auto] items-start">
    <AuthenticatedNavbar />

    <main class="mx-auto mb-20 mt-12 h-full w-full max-w-3xl px-6 lg:px-0">
      <slot />
    </main>
  </div>
</template>
