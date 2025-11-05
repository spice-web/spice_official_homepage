<template>
  <div class="top-page">
    <section class="hero">
      <div class="">
        <img src="assets/images/top/main.jpg" class="hero-image" width="100%">
        <div class="hero-headline-wrapper" ref="headlineRef">
          <h2 class="hero-headline" :class="{ 'animate-bounce-in': isVisible }">For Business<br>Give Spice.</h2>
          <span class="bracket bracket-top-left"></span>
          <span class="bracket bracket-top-right"></span>
          <span class="bracket bracket-bottom-left"></span>
          <span class="bracket bracket-bottom-right"></span>
        </div>
        <h3 class="hero-title">企業のプロジェクトに独自の刺激を</h3>
        <p class="hero-subtitle">企業のあらゆるプロジェクトに、<br class="is-block--sm">
          独自の視点で付加価値を加え、互いに成長していく。<br>
          株式会社スパイスは、客観的に俯瞰して目的を見据え、<br class="is-block--sm">
          新たな視点をご提案します。</p>
      </div>
    </section>

    <!-- パララックス-->
    <section class="section section-parallax section--service">
      <div class="section-content">
        <div class="container">
          <h2 class="section-title">事業・サービス</h2>
          <div class="section-title__en">Service</div>
        </div>
        <div class="right-box">
          <p class="title">自分たちが成長するために<br>
          新たな分野にも挑戦し続ける</p>
          <p class="txt">Eコマース事業、商品開発、ポイントカード事業、QRコード決済サービス、広告代理・制作など、独自のネットワークとフットワークで展開しています。</p>
        </div>
        <NuxtLink to="/business" class="button">サービス一覧</NuxtLink>
      </div>
    </section>

    <ul class="service-list">
      <li v-for="service in serviceItems" :key="service.label" class="service-list__item">
        <component
          :is="service.external ? 'a' : 'NuxtLink'"
          :to="service.external ? undefined : service.url"
          :href="service.external ? service.url : undefined"
          :aria-label="service.label"
        >
          {{ service.label }}
        </component>
      </li>
    </ul>

    <section class="section section-alt section-parallax section--product">
      <div class="section-content">
        <div class="container">
          <h2 class="section-title">商品開発&販売</h2>
          <div class="section-title__en">Product</div>
        </div>
        <div class="right-box">
          <p class="title">
            商品開発支援から販売サポートまで<br>トータルでサポート
          </p>
          <p class="txt">企業の商品の価値を高め、ターゲットに合った販売戦略を行います。ときには商品開発に携わり、適切な販売経路を模索し、ブランディングやパッケージの変更などあらゆる面からサポートします。</p>
        </div>
        <NuxtLink to="/products" class="button">取扱商品一覧</NuxtLink>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="section-title--news" ref="newsTitleRef" :class="{ 'animate-bounce-in': isNewsVisible }">
          <h2>
            <span class="lb"></span>
            News
            <span class="rt"></span>
          </h2>
        </div>
        <div class="news-list">
          <div v-if="newsPending" class="loading">読み込み中...</div>
          <div v-else-if="newsError" class="error">
            <p>データの取得に失敗しました</p>
          </div>
          <div v-else-if="newsData && newsData.contents && newsData.contents.length > 0">
            <article
              v-for="item in newsData.contents.slice(0, 5)"
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
                  <h3 class="news-title">{{ item.title }}</h3>
                </div>
              </NuxtLink>
            </article>
          </div>
          <p v-else class="no-content">お知らせはまだありません</p>
        </div>
        <NuxtLink to="/news" class="button">一覧を見る</NuxtLink>
      </div>
    </section>
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

useHead({
  title: '株式会社スパイス | Webサイト・DTP制作、コンサルティング｜広島県広島市',
  meta: [
    { name: 'description', content: '株式会社スパイスは、広島を拠点としてマーケティング・コンサルティングを得意とし、集客に強いサイト制作まで一貫して行っています。御社のターゲットユーザーを集客し、企画力とユーザビリティの高いデザインによって売上アップに貢献します。' }
  ]
})

const config = useRuntimeConfig()

// microCMSからニュースデータを取得（最新5件）
const { data: newsData, pending: newsPending, error: newsError } = await useFetch<NewsResponse>(
  'https://spice-web.microcms.io/api/v1/information',
  {
    headers: {
      'X-MICROCMS-API-KEY': config.public.microCmsApiKey as string
    },
    query: {
      orders: '-publishedAt',
      limit: 5,
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

// デバッグ用：データ構造を確認
if (newsData.value) {
  console.log('News data:', newsData.value)
  console.log('First item:', newsData.value.contents[0])
}

const headlineRef = ref<HTMLElement | null>(null)
const isVisible = ref(false)

const newsTitleRef = ref<HTMLElement | null>(null)
const isNewsVisible = ref(false)

const serviceItems = [
  { label: 'アパレル・雑貨ECサイト「フラッチ」運営', url: '/business#ec', external: false },
  { label: 'コンタクトレンズECサイト「アイズコンタクト」運営', url: '/business#ec', external: false },
  { label: '化粧品OEM', url: '/business#ec', external: false },
  { label: 'コンサルティング業務', url: '/business#ec', external: false },
  { label: 'QRコード決済サービス', url: '/business#qr', external: false },
  { label: '「クラブネッツ」CNポイント代理店', url: 'service.php#cn_point', external: true },
  { label: '旅行業支援システム・アシスト業務', url: '/business#tabi', external: false },
  { label: 'ホームページ・DTP制作', url: '/business#work_web', external: false },
  { label: '洗浄剤CODE販売店', url: '/business#code', external: false }
]

onMounted(() => {
  const observerOptions = {
    threshold: 0.3,
    rootMargin: '0px'
  }

  const observerCallback = (entries: IntersectionObserverEntry[], obs: IntersectionObserver) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        if (entry.target === headlineRef.value) {
          isVisible.value = true
        } else if (entry.target === newsTitleRef.value) {
          isNewsVisible.value = true
        }
        obs.unobserve(entry.target)
      }
    })
  }

  const observer = new IntersectionObserver(observerCallback, observerOptions)

  if (headlineRef.value) {
    observer.observe(headlineRef.value)
  }

  if (newsTitleRef.value) {
    observer.observe(newsTitleRef.value)
  }

  onUnmounted(() => {
    observer.disconnect()
  })
})
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

.hero {
  color: black;
  // padding: 5rem 0;
  text-align: center;
  margin-bottom: 2rem;
}

.hero-image {
  min-height: 400px;
  width: 100%;
  max-width: 950px;
  margin-left: auto;
  margin-right: auto;
  overflow: hidden;
  object-fit: cover;
}

.hero-headline-wrapper {
  position: relative;
  display: inline-block;
  margin: -4rem auto 1rem;
}

.hero-headline {
  display: inline-block;
  margin: 0 auto;
  line-height: 1;
  font-size: 2.8rem;
  padding: 2rem 3rem;
  opacity: 0;
  transform: scale(0.3);
  transition: opacity 0.5s ease, transform 0.5s ease;

  &.animate-bounce-in {
    animation: bounceIn 1s ease forwards;
  }
}

.hero-title {
  font-size: 1rem;
  margin-bottom: .25rem;
  // font-size: 2rem;
  font-weight: bold;
  // margin-bottom: 1rem;
  letter-spacing: 0.05em;
}

.hero-subtitle {
  font-size: 0.875rem;
  font-weight: bold;
}

@keyframes bounceIn {
  0% {
    opacity: 0;
    transform: scale(0.3);
  }
  40% {
    opacity: 1;
    transform: scale(1.05);
  }
  55% {
    transform: scale(0.9);
  }
  70% {
    transform: scale(1.02);
  }
  85% {
    transform: scale(0.98);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.bracket {
  position: absolute;
  width: 25px;
  height: 25px;
  border-style: solid;
  border-color: currentColor;
  &-top-left {
    top: 0;
    left: 0;
    border-width: 4px 0 0 4px;
  }
  &-top-right {
    top: 0;
    right: 0;
    border-width: 4px 4px 0 0;
  }
  &-bottom-left {
    bottom: 0;
    left: 0;
    border-width: 0 0 4px 4px;
  }
  &-bottom-right {
    bottom: 0;
    right: 0;
    border-width: 0 4px 4px 0;
  }
}

@media (min-width: 768px) {
  .hero {
    margin-bottom: 4rem;
  }
  .hero-headline {
    font-size: 4.5rem;
  }

  .hero-headline-wrapper {
    margin-bottom: 2rem;
  }

  .hero-title {
    font-size: 2rem;
  }

  .hero-subtitle {
    font-size: 1rem;
  }

  .bracket {
    width: 25px;
    height: 25px;
    border-width: 4px;
    &-top-left {
      border-width: 4px 0 0 4px;
    }
    &-top-right {
      border-width: 4px 4px 0 0;
    }
    &-bottom-left {
      border-width: 0 0 4px 4px;
    }
    &-bottom-right {
      border-width: 0 4px 4px 0;
    }
  }
}


// セクション
.section {
  padding: 4rem 0;

  &--service {
    background-image: url('~/assets/images/top/para-bg01.jpg');
  }
  &--product {
    background-image: url('~/assets/images/top/para-bg02.jpg');
  }
}

.section-parallax {
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  color: white;

  &::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background-color: rgba(0, 0, 0, 0.4); */
    z-index: 0;
  }

  .container,
  .button,
  .right-box,
  .section-content,
  .section-left {
    position: relative;
    z-index: 1;
  }
}

.section-content {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding: 0 1rem;
}

.section-title {
  width: 175px;
  text-align: center;
  background-color: #FFF;
  color: var(--color-primary);
  position: relative;
  // display: inline-block;
  font-size: 1rem;
  margin-bottom: 1rem;
  margin-left: auto;
  margin-right: auto;
  padding: .5rem 1rem;

  &::before {
    content: '';
    position: absolute;
    top: -4px;
    left: -4px;
    width: 100%;
    height: 25px;
    width: 25px;
    border-top: var(--color-primary) 4px solid;
    border-left: var(--color-primary) 4px solid;
    z-index: -1;
  }
  &::after {
    content: '';
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 25px;
    height: 25px;
    border-bottom: var(--color-primary) 4px solid;
    border-right: var(--color-primary) 4px solid;
    z-index: -1;
  }

  &__en {
    text-align: center;
    font-size: 2.667rem;
    font-weight: bold;
    letter-spacing: 0.05em;
  }

  &--news {
    text-align: center;
    background-color: transparent;
    color: var(--color-text);
    opacity: 0;
    transform: scale(0.3);
    transition: opacity 0.5s ease, transform 0.5s ease;
    margin-bottom: 2rem;

    &.animate-bounce-in {
      animation: bounceIn 1s ease forwards;
    }

    h2 {
      padding: 0 1rem;
      position: relative;
      display: inline-block;
      text-align: center;
      font-size: 2rem;
      
      &::after, &::before {
        content: "";
        width: 10px;
        height: 13px;
        position: absolute;
        display: inline-block;
      }
      &::before {
        border-left: solid 2px #000;
        border-top: solid 2px #000;
        top: 0;
        left: 0;
      }
      &::after {
        border-right: solid 2px #000;
        border-bottom: solid 2px #000;
        bottom: 0;
        right: 0;
      }
      .lb, .rt {
        width: 10px;
        height: 13px;
        position: absolute;
        display: inline-block;
      }
      .lb {
        border-left: solid 2px #000;
        border-bottom: solid 2px #000;
        bottom: 0;
        left: 0;
      }
      .rt {
        border-right: solid 2px #000;
        border-top: solid 2px #000;
        top: 0;
        right: 0;
      }
    }
  }
}

.right-box {
  .title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 1rem;
    text-align: center;
  }
  .txt {
    font-size: 1rem;
    line-height: 1.6;
  }
}

.section-alt {
  background-color: #f8f9fa;
}

.section-text {
  margin-bottom: 2rem;
  text-align: center;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

// レスポンシブ対応
@include responsive($breakpoint-md) {
  .section-parallax {
    padding: 3rem 1rem 2rem 1rem;
    height: 340px;
  }

  .section-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    max-width: 1200px;
    margin: 0 auto;
    gap: 2rem 3rem;
  }

  .section--service .container,
  .section--product .container {
    grid-column: 1;
    grid-row: 1 / 2;
  }

  .section--service .right-box,
  .section--product .right-box {
    grid-column: 2;
    grid-row: 1 / 3;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .section--service .button,
  .section--product .button {
    grid-column: 1;
    grid-row: 2;
    align-self: start;
  }

  .right-box {
    padding-left: 3rem;
    border-left: 1px solid rgba(255, 255, 255, 0.7);
    .title {
      text-align: left;
    }
  }
}

.button {
  display: inline-block;
  padding: 0 2rem;
  background-color: #000;
  color: white;
  line-height: 2rem;
  border-radius: 2rem;
  text-align: center;
  margin: 0 auto;
  display: block;
  width: fit-content;
  transition: background-color 0.3s;
}

.button:hover {
  background-color: var(--color-secondary);
  opacity: 1;
}



.service-list {
  width: 100%;
  max-width: 900px;
  display: grid;
  grid-template-columns: 1fr;
  column-gap: 1rem;
  list-style-type: none;
  margin-left: auto;
  margin-right: auto;
  padding: 3rem 1rem;
  &__item {
    line-height: 1.8;
    &::before {
      content: "●";
      color: #f1853c;
      display: inline-block;
      margin-right: 0.5rem;
    }
  }
}

@include responsive($breakpoint-md) {
  .service-list {
    grid-template-columns: repeat(2, 1fr);
    padding-left: 0;
    padding-right: 0;
  }
}

// =============================================
// ニュース一覧
// =============================================
.news-list {
  margin-bottom: 2rem;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;

  > div {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }
}

.loading,
.error {
  text-align: center;
  color: var(--color-secondary);
  padding: 2rem;
}

.no-content {
  text-align: center;
  color: var(--color-secondary);
  padding: 2rem;
}

.news-item {
  border: 1px solid var(--color-border);
  border-radius: 8px;
  overflow: hidden;
  transition: box-shadow 0.2s, transform 0.2s;

  &:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
  }
}

.news-link {
  display: flex;
  flex-direction: column;
  height: 100%;
  text-decoration: none;
  color: inherit;
}

.news-thumbnail {
  width: 100%;
  height: 180px;
  overflow: hidden;
  background-color: #f0f0f0;

  &-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
  }
}

.news-link:hover .news-thumbnail-image {
  transform: scale(1.05);
}

.news-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  padding: 1rem;
}

.news-meta {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.news-date {
  font-size: 0.75rem;
  color: var(--color-secondary);
  white-space: nowrap;
}

.news-category {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  background-color: #ea7329;
  color: white;
  font-size: 0.65rem;
  border-radius: 4px;
  white-space: nowrap;
}

.news-title {
  font-size: 0.9rem;
  font-weight: normal;
  color: #333;
  line-height: 1.6;
  margin: 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.news-link:hover .news-title {
  color: #ea7329;
}

@media (min-width: 768px) {
  .news-list > div {
    grid-template-columns: repeat(3, 1fr);
  }

  .news-thumbnail {
    height: 200px;
  }

  .news-title {
    font-size: 1rem;
  }
}

@media (min-width: 1024px) {
  .news-list > div {
    grid-template-columns: repeat(4, 1fr);
  }

  .news-thumbnail {
    height: 180px;
  }
}
</style>
