// https://nuxt.com/docs/api/configuration/nuxt-config

import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  ssr: false,
  devtools: { enabled: true },
  srcDir: './src/',
  modules: [
    '@pinia/nuxt',
    'pinia-plugin-persistedstate',
    'shadcn-nuxt',
    '@formkit/auto-animate',
    'nuxt-lucide-icons',
    '@vueuse/motion/nuxt'
  ],
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_LARAVEL_API_URL
    }
  },

  css: ['./src/assets/css/main.css'],
  vite: {
    plugins: [
      tailwindcss()
    ]
  }
})