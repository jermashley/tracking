<script setup>
import Navbar from '@/components/layout/navbar/Navbar.vue'
</script>

<template>
  <div class="grid min-h-screen grid-rows-[auto,1fr] items-start">
    <Navbar />

    <main class="mx-auto w-full max-w-3xl pt-12">
      <slot />
    </main>
  </div>
</template>
