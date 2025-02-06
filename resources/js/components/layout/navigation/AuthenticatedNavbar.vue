<script setup>
import { Link, usePage } from '@inertiajs/vue3'

import UserDropdown from '@/components/feature/user/navigation/UserDropdown.vue'
import { Button } from '@/components/ui/button'
import {
  NavigationMenu,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
  navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu'

const {
  auth: { user },
} = usePage().props
</script>

<template>
  <header
    class="sticky top-0 z-50 w-full border-b border-b-border/70 bg-background/70 backdrop-blur-lg"
  >
    <nav
      class="relative mx-auto flex h-16 w-full max-w-3xl flex-row items-center justify-center px-6 lg:px-0"
    >
      <NavigationMenu>
        <NavigationMenuList>
          <NavigationMenuItem>
            <NavigationMenuLink :class="navigationMenuTriggerStyle()" as-child>
              <Link :href="route('admin.dashboard')">Dashboard</Link>
            </NavigationMenuLink>
          </NavigationMenuItem>
        </NavigationMenuList>
      </NavigationMenu>

      <div class="ml-auto flex flex-row items-center justify-end space-x-4">
        <p
          class="whitespace-nowrap text-lg font-extrabold text-zinc-700 dark:text-zinc-200"
        >
          {{ $page.props.app.name }}
        </p>

        <UserDropdown v-if="user" />
      </div>
    </nav>
  </header>
</template>
