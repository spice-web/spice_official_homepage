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
      <div class="news-list">
        <div v-if="pending" class="loading">読み込み中...</div>
        <div v-else-if="error" class="error">
          <p>データの取得に失敗しました</p>
          <p class="error-message">{{ error.message }}</p>
        </div>
        <div v-else-if="data && data.contents && data.contents.length > 0">
          <article
            v-for="item in data.contents"
            :key="item.id"
            class="news-item"
          >
            <NuxtLink :to="`/news/${item.id}`" class="news-link">
              <div v-if="item.thumbnail" class="news-thumbnail">
                <img
                  :src="item.thumbnail.url"
                  :alt="item.title"
                  class="news-thumbnail-image"
                >
              </div>
              <div class="news-content">
                <div class="news-meta">
                  <time class="news-date" :datetime="item.publishedAt">
                    {{ formatDate(item.publishedAt) }}
                  </time>
                  <span v-if="item.category" class="news-category">
                    {{ item.category.name }}
                  </span>
                </div>
                <h2 class="news-title">{{ item.title }}</h2>
              </div>
            </NuxtLink>
          </article>
        </div>
        <p v-else class="no-content">お知らせはまだありません</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// 型定義
interface Category {
  id: string
  name: string
}

interface Thumbnail {
  url: string
  height: number
  width: number
}

interface NewsItem {
  id: string
  title: string
  content: string
  publishedAt: string
  category?: Category
  thumbnail?: Thumbnail
}

interface NewsResponse {
  contents: NewsItem[]
  totalCount: number
  offset: number
  limit: number
}

const breadcrumbItems = [
  { label: '新着情報' }
]

useHead({
  title: '新着情報 - 株式会社スパイス | 広島のweb・DTP制作会社',
  meta: [
    { name: 'description', content: '株式会社スパイスの新着情報・お知らせ一覧です。' }
  ]
})

const config = useRuntimeConfig()

// microCMSからデータ取得
const { data, pending, error } = await useFetch<NewsResponse>(
  'https://spice-web.microcms.io/api/v1/information',
  {
    headers: {
      'X-MICROCMS-API-KEY': config.public.microCmsApiKey as string
    },
    query: {
      orders: '-publishedAt',
      limit: 50,
      fields: 'id,title,content,publishedAt,category,thumbnail'
    }
  }
)

// 日付フォーマット関数
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  const year = date.getFullYear()
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  return `${year}.${month}.${day}`
}
</script>

<style scoped>
.news-list {
  min-height: 400px;
  max-width: 900px;
  margin: 0 auto;
  padding: 2rem 0;
}

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

.no-content {
  text-align: center;
  color: var(--color-secondary);
  padding: 4rem 2rem;
}

.news-item {
  border-bottom: 1px solid var(--color-border);
  transition: background-color 0.2s;
}

.news-item:hover {
  background-color: #f8f9fa;
}

.news-link {
  display: flex;
  gap: 1.5rem;
  padding: 1.5rem 1rem;
  text-decoration: none;
  color: inherit;
}

.news-thumbnail {
  flex-shrink: 0;
  width: 120px;
  height: 80px;
  overflow: hidden;
  border-radius: 4px;
}

.news-thumbnail-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s;
}

.news-link:hover .news-thumbnail-image {
  transform: scale(1.1);
}

.news-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.news-meta {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.news-date {
  font-size: 0.875rem;
  color: var(--color-secondary);
  white-space: nowrap;
}

.news-category {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  background-color: var(--color-primary, #007bff);
  color: white;
  font-size: 0.75rem;
  border-radius: 4px;
  white-space: nowrap;
}

.news-title {
  font-size: 1rem;
  font-weight: normal;
  color: #333;
  line-height: 1.6;
}

.news-link:hover .news-title {
  color: var(--color-primary, #007bff);
}

@media (max-width: 767px) {
  .news-link {
    gap: 1rem;
    padding: 1rem;
  }

  .news-thumbnail {
    width: 100px;
    height: 70px;
  }

  .news-meta {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }

  .news-title {
    font-size: 0.9375rem;
  }
}
</style>
