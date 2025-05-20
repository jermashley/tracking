import { createInertiaApp } from '@inertiajs/vue3'
import { VueQueryPlugin } from '@tanstack/vue-query'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import posthog from 'posthog-js'
import { createApp, h } from 'vue'

import { ZiggyVue } from '../../vendor/tightenco/ziggy'

if (import.meta.env.VITE_APP_ENV === `production`) {
  posthog.init(import.meta.env.VITE_POSTHOG_TOKEN, {
    api_host: import.meta.env.VITE_POSTHOG_API_HOST,
    person_profiles: `always`,
  })
}

createInertiaApp({
  title: (title) => `${title}`,
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob(`./pages/**/*.vue`),
    ),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueQueryPlugin, { enableDevtoolsV6Plugin: true })
      .use(ZiggyVue)
      .mount(el)
  },
  progress: { color: `#4B5563` },
})
