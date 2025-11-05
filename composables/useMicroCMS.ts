import { createClient, type MicroCMSQueries } from 'microcms-js-sdk'

// サイト制作一覧を取得
export const useSiteProduction = async () => {
  const config = useRuntimeConfig()

  const client = createClient({
    serviceDomain: config.public.microCmsServiceDomain as string,
    apiKey: config.public.microCmsApiKey as string,
  })

  try {
    const response = await client.get({
      endpoint: 'site-production',
      queries: {
        limit: 100
      } as MicroCMSQueries
    })
    return response
  } catch (error) {
    console.error('microCMS fetch error:', error)
    return null
  }
}

// 商品一覧を取得
export const useProducts = async () => {
  const config = useRuntimeConfig()

  const client = createClient({
    serviceDomain: config.public.microCmsServiceDomain as string,
    apiKey: config.public.microCmsApiKey as string,
  })

  try {
    const response = await client.get({
      endpoint: 'products',
      queries: {
        limit: 100
      } as MicroCMSQueries
    })
    return response
  } catch (error) {
    console.error('microCMS fetch error:', error)
    return null
  }
}
