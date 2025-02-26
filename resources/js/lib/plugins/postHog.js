import posthog from 'posthog-js'

export default {
  install(app) {
    if (import.meta.env.VITE_APP_ENV === `production`) {
      app.config.globalProperties.$posthog = posthog.init(
        import.meta.env.VITE_POSTHOG_TOKEN,
        {
          api_host: import.meta.env.VITE_POSTHOG_API_HOST,
        },
      )
    }
  },
}
