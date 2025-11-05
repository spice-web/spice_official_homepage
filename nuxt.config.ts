// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },

  // TypeScript設定
  typescript: {
    strict: true,
    typeCheck: true
  },

  // アプリケーション設定
  app: {
    head: {
      charset: 'utf-8',
      viewport: 'width=device-width, initial-scale=1',
      title: 'SPICE - 会社ホームページ',
      meta: [
        { name: 'description', content: 'SPICE会社ホームページ' },
        { name: 'format-detection', content: 'telephone=no' }
      ],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
      ]
    }
  },

  // CSS設定
  css: [
    '@fortawesome/fontawesome-svg-core/styles.css',
    '@/assets/css/main.scss'
  ],

  // モジュール
  modules: [
    '@nuxt/fonts',
    '@nuxtjs/sitemap'
  ],

  // フォント設定
  fonts: {
    families: [
      { name: 'Noto Sans JP', provider: 'google' }
    ]
  },

  // サイトマップ設定
  site: {
    url: 'https://spice-web.jp',
    name: 'SPICE'
  },

  sitemap: {
    sources: [
      '/api/__sitemap__/urls'
    ]
  },

  // ランタイム設定
  runtimeConfig: {
    // サーバーサイドのみ
    microCmsApiKey: process.env.MICROCMS_API_KEY,
    microCmsServiceDomain: process.env.MICROCMS_SERVICE_DOMAIN,

    // クライアントサイドでも利用可能
    public: {
      gtmId: process.env.GTM_ID || 'GTM-56C5JFV',
      turnstileSiteKey: process.env.TURNSTILE_SITE_KEY,
      microCmsApiKey: process.env.MICROCMS_API_KEY,
      microCmsServiceDomain: process.env.MICROCMS_SERVICE_DOMAIN?.replace('https://', '').replace('http://', '').replace('.microcms.io', '')
    }
  },

  // ビルド設定
  nitro: {
    prerender: {
      crawlLinks: true,
      routes: [
        '/',
        '/business',
        '/products',
        '/news',
        '/about',
        '/contact',
        '/privacy',
        '/sitemap',
        '/tokushoho'
      ],
      // テストページを本番ビルドから除外
      ignore: [
        '/test-error'
      ]
    }
  },

  // ルーター設定 - 本番環境でテストページを除外
  hooks: {
    'pages:extend'(pages) {
      // 本番環境の場合、test-errorページを削除
      if (process.env.NODE_ENV === 'production') {
        const testErrorIndex = pages.findIndex(page => page.path === '/test-error')
        if (testErrorIndex !== -1) {
          pages.splice(testErrorIndex, 1)
        }
      }
    }
  }
})
