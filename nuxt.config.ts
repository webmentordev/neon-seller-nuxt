// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ['@nuxtjs/tailwindcss', 'nuxt-icon', "@nuxt/image"],
  runtimeConfig: {
    'api': process.env.NUXT_API,
    public: {
      'api': process.env.NUXT_PUBLIC_API,
    }
  },
  image: {
    domains: ['localhost:8000']
  },
  app: {
    head: {
      title: "Neon Seller - Custom & Colorful Neon Signs",
      link: [
        {
          rel: "shortcut icon",
          href: "/logo.png"
        }
      ],
      charset: 'utf-8',
      viewport: 'width=device-width, initial-scale=1',
      meta: [
        {
          name: "description",
          content: "Premium Quality at an affordable price - Create your own custom neon signs in minutes. Shop our range or send us an image and receive a free quote"
        }
      ]
    }
  },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {}
    }
  },
  routeRules: {
    '/': { prerender: true },
    '/dashboard/**': { ssr: false },
  }
})