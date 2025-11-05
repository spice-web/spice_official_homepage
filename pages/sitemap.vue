<template>
  <div class="page">
    <div class="l-header-page">
      <div class="container">
        <h1 class="l-header-page__title">
          Sitemap
          <span>サイトマップ</span>
        </h1>
      </div>
    </div>
    <Breadcrumb :items="breadcrumbItems" />

    <div class="container">
      <section class="content-section">
        <ul class="sitemap-list">
          <li v-for="item in sitemapItems" :key="item.path" class="sitemap-item">
            <NuxtLink :to="item.path" class="sitemap-link">
              {{ item.label }}
            </NuxtLink>
            <ul v-if="item.children" class="sitemap-sublist">
              <li v-for="child in item.children" :key="child.path">
                <NuxtLink :to="child.path" class="sitemap-link">
                  {{ child.label }}
                </NuxtLink>
              </li>
            </ul>
          </li>
        </ul>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
interface SitemapItem {
  path: string
  label: string
  children?: SitemapItem[]
}

const breadcrumbItems = [
  { label: 'サイトマップ' }
]

useHead({
  title: 'サイトマップ | 広島のweb・DTP制作会社 株式会社スパイス',
  meta: [
    { name: 'description', content: '株式会社スパイスのサイトマップです。' }
  ]
})

const sitemapItems: SitemapItem[] = [
  { path: '/', label: 'トップページ' },
  { path: '/business', label: '事業内容' },
  { path: '/products', label: '商品開発&販売' },
  { path: '/news', label: '新着情報' },
  { path: '/about', label: '会社概要' },
  { path: '/contact', label: 'お問い合わせ' },
  { path: '/privacy', label: 'プライバシーポリシー' },
  { path: '/tokushoho', label: '特定商取引法に基づく表記' },
  { path: '/sitemap', label: 'サイトマップ' }
]
</script>

<style scoped lang="scss">
.content-section {
  max-width: 800px;
  margin: 0 auto 3rem;
}

.sitemap-list {
  list-style: none;
}

.sitemap-item {
  margin-bottom: 1.5rem;
  position: relative;
  padding-left: 1.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid var(--color-border);

  &::before {
    content: "›";
    position: absolute;
    left: 0;
    top: 0.5rem;
    color: #ea7329;
    font-size: 1.25rem;
    font-weight: bold;
  }
}

.sitemap-link {
  color: var(--color-primary);
  font-size: 1.125rem;
  display: block;
  padding: 0.5rem 0;
  text-decoration: none;
  transition: color 0.3s;
}

.sitemap-link:hover {
  color: var(--color-accent);
}

.sitemap-sublist {
  list-style: none;
  padding-left: 2rem;
  margin-top: 0.5rem;
}

.sitemap-sublist .sitemap-link {
  font-size: 1rem;
  border-bottom: none;
}
</style>
