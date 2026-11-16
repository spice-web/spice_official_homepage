import { createClient, type MicroCMSQueries } from 'microcms-js-sdk'

// microCMSへのアクセスはサーバー側（ビルド時のプリレンダリング含む）でのみ行う。
// APIキーは private runtimeConfig から取得し、クライアントには一切渡さない。

// 取得を許可するエンドポイント
const ALLOWED_ENDPOINTS = ['information', 'site-production', 'products'] as const
export type MicroCMSEndpoint = typeof ALLOWED_ENDPOINTS[number]

// クライアントから受け付けるクエリパラメータ
const ALLOWED_QUERY_KEYS = ['orders', 'limit', 'offset', 'fields', 'filters', 'q', 'ids', 'depth'] as const

export const assertEndpoint = (endpoint: string | undefined): MicroCMSEndpoint => {
  if (!endpoint || !(ALLOWED_ENDPOINTS as readonly string[]).includes(endpoint)) {
    throw createError({ statusCode: 404, statusMessage: 'Not Found' })
  }
  return endpoint as MicroCMSEndpoint
}

export const pickQueries = (query: Record<string, unknown>): MicroCMSQueries => {
  const queries: Record<string, unknown> = {}
  for (const key of ALLOWED_QUERY_KEYS) {
    const value = query[key]
    if (typeof value === 'string' && value !== '') {
      queries[key] = value
    }
  }
  return queries as MicroCMSQueries
}

export const getMicroCMSClient = () => {
  const config = useRuntimeConfig()
  const serviceDomain = String(config.microCmsServiceDomain || '')
    .replace(/^https?:\/\//, '')
    .replace(/\.microcms\.io\/?$/, '')
  const apiKey = String(config.microCmsApiKey || '')

  if (!serviceDomain || !apiKey) {
    throw createError({ statusCode: 500, statusMessage: 'microCMS is not configured' })
  }

  return createClient({ serviceDomain, apiKey })
}

// microCMSのエラーをステータスコード付きのエラーに変換
export const toMicroCMSError = (error: unknown) => {
  console.error('microCMS fetch error:', error)
  const message = error instanceof Error ? error.message : ''
  const statusCode = /status:\s*404/.test(message) ? 404 : 502
  return createError({ statusCode, statusMessage: statusCode === 404 ? 'Not Found' : 'microCMS fetch error' })
}
