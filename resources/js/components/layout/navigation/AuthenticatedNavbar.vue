<script setup>
import { faChartTreeMap } from '@fortawesome/pro-duotone-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { Link, usePage } from '@inertiajs/vue3'

import UserDropdown from '@/components/feature/user/navigation/UserDropdown.vue'
import { Button } from '@/components/ui/button'
import {
  NavigationMenu,
  NavigationMenuContent,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
  NavigationMenuTrigger,
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
              <Link :href="route('admin.dashboard')">
                <FontAwesomeIcon
                  class="mr-2"
                  :icon="faChartTreeMap"
                  fixed-width
                />

                Dashboard
              </Link>
            </NavigationMenuLink>
          </NavigationMenuItem>

          <!-- <NavigationMenuItem>
            <NavigationMenuTrigger> Manage </NavigationMenuTrigger>
            <NavigationMenuContent>
              <ul
                class="grid w-[400px] gap-3 p-4 md:w-[500px] md:grid-cols-2 lg:w-[600px]"
              >
                <li>
                  <NavigationMenuLink as-child>
                    <a
                      href="#"
                      class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                    >
                      <div class="text-sm font-medium leading-none">Themes</div>
                      <p
                        class="line-clamp-2 text-sm leading-snug text-muted-foreground"
                      >
                        Create and edit custom themes.
                      </p>
                    </a>
                  </NavigationMenuLink>
                </li>

                <li>
                  <NavigationMenuLink as-child>
                    <a
                      href="#"
                      class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                    >
                      <div class="text-sm font-medium leading-none">Images</div>
                      <p
                        class="line-clamp-2 text-sm leading-snug text-muted-foreground"
                      >
                        Manage image library.
                      </p>
                    </a>
                  </NavigationMenuLink>
                </li>
              </ul>
            </NavigationMenuContent>
          </NavigationMenuItem> -->
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
