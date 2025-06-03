import { usePage } from '@inertiajs/vue3'
import { onMounted } from 'vue'

const useCompanyTheme = () => {
  const { initialCompany } = usePage().props
  const { theme } = initialCompany ?? { theme: undefined }
  const { colors } = theme ?? { colors: undefined }

  onMounted(() => {
    if (colors) {
      document.documentElement.style.setProperty(
        `--background`,
        colors.root.background,
      )
      document.documentElement.style.setProperty(
        `--foreground`,
        colors.root.foreground,
      )
      document.documentElement.style.setProperty(`--muted`, colors.root.muted)
      document.documentElement.style.setProperty(
        `--muted-foreground`,
        colors.root.mutedForeground,
      )
      document.documentElement.style.setProperty(
        `--popover`,
        colors.root.popover,
      )
      document.documentElement.style.setProperty(
        `--popover-foreground`,
        colors.root.popoverForeground,
      )
      document.documentElement.style.setProperty(`--card`, colors.root.card)
      document.documentElement.style.setProperty(
        `--card-foreground`,
        colors.root.cardForeground,
      )
      document.documentElement.style.setProperty(`--border`, colors.root.border)
      document.documentElement.style.setProperty(`--input`, colors.root.input)
      document.documentElement.style.setProperty(
        `--primary`,
        colors.root.primary,
      )
      document.documentElement.style.setProperty(
        `--primary-foreground`,
        colors.root.primaryForeground,
      )
      document.documentElement.style.setProperty(
        `--secondary`,
        colors.root.secondary,
      )
      document.documentElement.style.setProperty(
        `--secondary-foreground`,
        colors.root.secondaryForeground,
      )
      document.documentElement.style.setProperty(`--accent`, colors.root.accent)
      document.documentElement.style.setProperty(
        `--accent-foreground`,
        colors.root.accentForeground,
      )
      document.documentElement.style.setProperty(
        `--destructive`,
        colors.root.destructive,
      )
      document.documentElement.style.setProperty(
        `--destructive-foreground`,
        colors.root.destructiveForeground,
      )
      document.documentElement.style.setProperty(`--ring`, colors.root.ring)
    }
  })
}

export default useCompanyTheme
