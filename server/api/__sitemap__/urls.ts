import { defineEventHandler } from 'h3'

export default defineEventHandler(() => {
  return [
    {
      loc: '/',
      lastmod: new Date().toISOString(),
      changefreq: 'daily',
      priority: 1.0
    },
    {
      loc: '/business',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly',
      priority: 0.8
    },
    {
      loc: '/products',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly',
      priority: 0.8
    },
    {
      loc: '/news',
      lastmod: new Date().toISOString(),
      changefreq: 'daily',
      priority: 0.9
    },
    {
      loc: '/about',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly',
      priority: 0.7
    },
    {
      loc: '/contact',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly',
      priority: 0.6
    },
    {
      loc: '/privacy',
      lastmod: new Date().toISOString(),
      changefreq: 'yearly',
      priority: 0.3
    },
    {
      loc: '/tokushoho',
      lastmod: new Date().toISOString(),
      changefreq: 'yearly',
      priority: 0.3
    },
    {
      loc: '/sitemap',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly',
      priority: 0.4
    }
  ]
})
