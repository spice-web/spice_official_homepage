<template>
  <div class="page">
    <div class="l-header-page">
      <div class="container">
        <h1 class="l-header-page__title">
          News
          <span>新着情報</span>
        </h1>
      </div>
    </div>
    <Breadcrumb :items="breadcrumbItems" />

    <div class="container">
      <div v-if="pending" class="loading">読み込み中...</div>
      <div v-else-if="error" class="error">
        <p>データの取得に失敗しました</p>
        <p class="error-message">{{ error.message }}</p>
      </div>
      <article v-else-if="data" class="news-detail">
        <header class="news-header">
          <div class="news-meta">
            <time class="news-date" :datetime="data.publishedAt">
              {{ formatDate(data.publishedAt) }}
            </time>
            <span v-if="data.category" class="news-category">
              {{ data.category.name }}
            </span>
          </div>
          <h1 class="news-title">{{ data.title }}</h1>
        </header>
        <div v-if="data.thumbnail" class="news-thumbnail">
          <img
            :src="data.thumbnail.url"
            :alt="data.title"
            :width="data.thumbnail.width"
            :height="data.thumbnail.height"
          />
        </div>
        <div class="news-content" v-html="data.body"></div>
        <div class="news-footer">
          <NuxtLink to="/news" class="back-link">
            ← 一覧に戻る
          </NuxtLink>
        </div>
      </article>
    </div>
  </div>
</template>

<script setup lang="ts">
// 型定義
interface Category {
  id: string
  name: string
}

interface NewsDetail {
  id: string
  title: string
  content: string
  body: string
  thumbnail?: {
    url: string
    width?: number
    height?: number
  }
  publishedAt: string
  category?: Category
}

const route = useRoute()
const config = useRuntimeConfig()

const breadcrumbItems = [
  { label: '新着情報', path: '/news' },
  { label: '詳細' }
]

// microCMSからデータ取得
const { data, pending, error } = await useFetch<NewsDetail>(
  `https://spice-web.microcms.io/api/v1/information/${route.params.id}`,
  {
    headers: {
      'X-MICROCMS-API-KEY': config.public.microCmsApiKey as string
    }
  }
)

// メタ情報の設定
useHead(() => ({
  title: data.value ? `${data.value.title} - 新着情報 - 株式会社スパイス | 広島のweb・DTP制作会社` : '新着情報 - 株式会社スパイス | 広島のweb・DTP制作会社',
  meta: [
    {
      name: 'description',
      content: data.value?.title || '株式会社スパイスの新着情報詳細です。'
    }
  ]
}))

// 日付フォーマット関数
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  const year = date.getFullYear()
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  return `${year}.${month}.${day}`
}
</script>

<style scoped lang="scss">
.loading,
.error {
  text-align: center;
  color: var(--color-secondary);
  padding: 4rem 2rem;
}

.error-message {
  font-size: 0.875rem;
  color: #e74c3c;
  margin-top: 0.5rem;
}

.news-detail {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem 1rem;
}

.news-header {
  margin-bottom: 3rem;
  padding-bottom: 2rem;
  border-bottom: 2px solid var(--color-border);
}

.news-meta {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.news-date {
  font-size: 0.875rem;
  color: var(--color-secondary);
}

.news-category {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background-color: var(--color-primary, #007bff);
  color: white;
  font-size: 0.75rem;
  border-radius: 4px;
}

.news-title {
  font-size: 1.75rem;
  line-height: 1.6;
  color: #333;
}

.news-thumbnail {
  margin-bottom: 2rem;
}

.news-thumbnail img {
  width: 100%;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.news-content {
  line-height: 1.8;
  color: #333;
  margin-bottom: 3rem;
}

.news-content :deep(h2) {
  font-size: 1.5rem;
  margin-top: 2rem;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid var(--color-border);
}

.news-content :deep(h3) {
  font-size: 1.25rem;
  margin-top: 1.5rem;
  margin-bottom: 0.75rem;
}

.news-content :deep(p) {
  margin-bottom: 1rem;
}

.news-content :deep(img) {
  max-width: 100%;
  height: auto;
  margin: 1.5rem 0;
}

.news-content :deep(ul),
.news-content :deep(ol) {
  margin-bottom: 1rem;
  padding-left: 2rem;
}

.news-content :deep(li) {
  margin-bottom: 0.5rem;
}

.news-content :deep(a) {
  color: var(--color-primary, #007bff);
  text-decoration: underline;
}

.news-content :deep(a:hover) {
  text-decoration: none;
}

.news-footer {
  padding-top: 2rem;
  border-top: 1px solid var(--color-border);
}

.back-link {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  background-color: #f8f9fa;
  color: #333;
  text-decoration: none;
  border-radius: 4px;
  transition: background-color 0.2s;
}

.back-link:hover {
  background-color: #e9ecef;
}

@media (max-width: 767px) {
  .news-detail {
    padding: 1rem;
  }

  .news-title {
    font-size: 1.5rem;
  }

  .news-content :deep(h2) {
    font-size: 1.25rem;
  }

  .news-content :deep(h3) {
    font-size: 1.125rem;
  }
}
</style>
