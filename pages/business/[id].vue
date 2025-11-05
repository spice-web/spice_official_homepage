<template>
  <div class="page">
    <div class="l-header-page">
      <div class="container">
        <h1 class="l-header-page__title">
          Service
          <span>事業・サービス</span>
        </h1>
      </div>
    </div>
    <Breadcrumb :items="breadcrumbItems" />

    <div class="container">
      <article v-if="article" class="article-detail">
        <h1 class="article-title">{{ article.title }}様</h1>

        <img v-if="article.thumbnail" :src="article.thumbnail.url" :alt="article.title" class="article-thumbnail">

        <div class="article-content" v-html="article.content"></div>

        <div v-if="article.url" class="article-url">
          <p>サイトURL: {{ article.url }}</p>
        </div>

        <div class="article-meta">
          <time class="article-date">公開日: {{ formatDate(article.publishedAt) }}</time>
        </div>

        <div class="article-actions">
          <NuxtLink to="/business" class="back-link">← 一覧に戻る</NuxtLink>
        </div>
      </article>

      <div v-else class="loading">
        <p>読み込み中...</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const route = useRoute()
const id = route.params.id as string

// microCMSから記事詳細を取得
const { data: article } = await useAsyncData(`site-production-${id}`, async () => {
  const config = useRuntimeConfig()
  const { createClient } = await import('microcms-js-sdk')

  const client = createClient({
    serviceDomain: config.public.microCmsServiceDomain as string,
    apiKey: config.public.microCmsApiKey as string,
  })

  try {
    const response = await client.get({
      endpoint: 'site-production',
      contentId: id,
    })
    return response
  } catch (error) {
    console.error('microCMS fetch error:', error)
    return null
  }
})

// 日付フォーマット
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('ja-JP', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const breadcrumbItems = computed(() => [
  { label: '事業・サービス', path: '/business' },
  { label: article.value?.title || '詳細' }
])

useHead({
  title: article.value ? `${article.value.title} - 過去のサイト制作実績 - 株式会社スパイス | 広島のweb・DTP制作会社` : '事業内容 - 株式会社スパイス | 広島のweb・DTP制作会社',
  meta: [
    { name: 'description', content: article.value?.title || '過去のサイト制作実績の内容詳細です。' }
  ]
})
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

.article-detail {
  max-width: 800px;
  margin: 0 auto 3rem;
  padding: 2rem 0;
}

.article-title {
  font-size: 2rem;
  margin-bottom: 2rem;
  color: var(--color-primary);
  font-weight: bold;
  text-align: center;
  line-height: 1.4;
}

.article-thumbnail {
  width: 100%;
  height: auto;
  border-radius: 8px;
  margin-bottom: 2rem;
  object-fit: cover;
}

.article-content {
  line-height: 1.8;
  color: var(--color-secondary);
  margin-bottom: 2rem;

  :deep(h2) {
    font-size: 1.5rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--color-border);
  }

  :deep(h3) {
    font-size: 1.25rem;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
  }

  :deep(p) {
    margin-bottom: 1rem;
  }

  :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin: 1.5rem 0;
  }

  :deep(ul), :deep(ol) {
    margin-bottom: 1rem;
    padding-left: 2rem;
  }

  :deep(li) {
    margin-bottom: 0.5rem;
  }
}

.article-url {
  // text-align: center;
  margin-bottom: 2rem;
}

.url-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.875rem 2rem;
  background-color: var(--color-primary);
  color: #fff;
  border-radius: 4px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;

  .icon {
    font-size: 0.875rem;
  }

  &:hover {
    opacity: 0.8;
    transform: translateY(-2px);
  }
}

.article-meta {
  margin-bottom: 2rem;
  padding-top: 2rem;
  border-top: 1px solid var(--color-border);
}

.article-date {
  color: var(--color-secondary);
  font-size: 0.875rem;
}

.article-actions {
  text-align: center;
  margin-top: 3rem;
}

.back-link {
  display: inline-block;
  padding: 0.75rem 2rem;
  background-color: var(--color-primary);
  color: #fff;
  border-radius: 4px;
  text-decoration: none;
  transition: opacity 0.3s ease;

  &:hover {
    opacity: 0.8;
  }
}

.loading {
  text-align: center;
  padding: 4rem 2rem;
  color: var(--color-secondary);
}

@include responsive($breakpoint-md) {
  .article-title {
    font-size: 1.5rem;
  }
}
</style>
