import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import path from 'path'
import { defineConfig } from 'vite'

export default defineConfig({
  plugins: [
    laravel({
      input: [`resources/css/app.css`, `resources/js/app.js`],
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  resolve: {
    alias: {
      'tailwind.config.js': path.resolve(__dirname, `tailwind.config.js`),
      '@': `/resources/js`,
    },
  },
})
