import { usePreferredColorScheme, useStorage } from '@vueuse/core'
import { watch } from 'vue'

const useSystemTheme = () => {
  const preferredColorScheme = usePreferredColorScheme()

  const theme = useStorage(`theme`, preferredColorScheme.value)

  const body = document.body

  body.classList.toggle(`dark`, theme.value === `dark`)

  const setTheme = (themeValue) => {
    theme.value = themeValue

    body.classList.toggle(`dark`)
  }

  watch(theme, (value) => setTheme(value))

  return {
    theme,
    setTheme,
  }
}

export default useSystemTheme
