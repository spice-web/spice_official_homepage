<template>
  <div class="page">
    <div class="l-header-page">
      <div class="container">
        <h1 class="l-header-page__title">
          Products
          <span>商品開発&販売</span>
        </h1>
      </div>
    </div>
    <Breadcrumb :items="breadcrumbItems" />

    <div class="container">
      <section class="content-section">
        <h2>商品開発</h2>
        <div v-if="productsData && productsData.contents && productsData.contents.length > 0" class="product-list">
          <article
            v-for="product in productsData.contents"
            :key="product.id"
            class="product-list__box"
            :class="{ 'clickable': product.url }"
            @click="navigateToProduct(product.url)"
          >
            <div class="product-list__img">
              <img
                :src="product.image.url"
                :alt="product.name"
                class="product-image"
                width="100%"
              >
            </div>
            <h4 class="product-name">
              {{ product.name }}
            </h4>
            <p class="product_txt">{{ product.description }}</p>
          </article>
        </div>
        <p v-else class="no-content">商品情報はまだありません</p>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
// 型定義
interface Product {
  id: string
  name: string
  image: {
    url: string
    height: number
    width: number
  }
  url?: string
  description: string
}

interface ProductsResponse {
  contents: Product[]
  totalCount: number
  offset: number
  limit: number
}

const breadcrumbItems = [
  { label: '商品開発&販売' }
]

// microCMSから商品データを取得
const { data: productsData } = await useAsyncData('products', async () => {
  return await useProducts()
})

// 商品ページへ遷移
const navigateToProduct = (url?: string) => {
  if (url) {
    window.open(url, '_blank', 'noopener,noreferrer')
  }
}

useHead({
  title: '商品開発&販売 | 広島のweb・DTP制作会社 株式会社スパイス',
  meta: [
    { name: 'description', content: '株式会社スパイスは、販路の拡大や弊社のノウハウを生かし幅広いユーザーに対しアプローチすることによって、売上アップに貢献致します。是非一度、ご相談ください。' }
  ]
})
</script>

<style scoped lang="scss">
.content-section {
  margin-bottom: 3rem;
}

.content-section h2 {
  font-size: 1.75rem;
  margin-bottom: 2rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid var(--color-border);
}

.content-section p {
  line-height: 1.8;
  color: var(--color-secondary);
}

.product-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  margin-top: 2rem;

  &__box {
    background: #fff;
    border: 1px solid var(--color-border);
    // border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;

    &.clickable {
      cursor: pointer;

      &:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
    }
  }

  &__img {
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #f8f9fa;

    a {
      display: block;
      width: 100%;
      height: 100%;
    }

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s;

      &:hover {
        transform: scale(1.05);
      }
    }
  }
}

.product-name {
  padding: 1rem 1rem 0.5rem;
  font-size: 1.125rem;
  font-weight: bold;
  line-height: 1.5;

  a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;

    &:hover {
      color: var(--color-primary, #007bff);
    }
  }
}

.product-list__img {
  position: relative;
  aspect-ratio: 27 / 20;
  
  &::after {
    content: "";
    position: absolute;
    width: 80%;
    height: 80%;
    top: 10%;
    left: 10%;
    opacity: 0;
    transition: all .4s cubic-bezier(0.165, 0.84, 0.44, 1);
    background: rgba(234, 118, 43, .9);
  }
  
  &:hover::after {
    opacity: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
  }
}

.product_txt {
  padding: 0 1rem 1.5rem;
  font-size: 0.9375rem;
  line-height: 1.7;
  color: #666;
}

.product-name {
  text-align: center;
  a {
    color: #ea7329;
  }
}

.no-content {
  text-align: center;
  color: var(--color-secondary);
  padding: 2rem;
  font-size: 1rem;
}

@media (max-width: 767px) {
  .product-list {
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
  }

  .product-name {
    font-size: 1rem;
  }

  .product_txt {
    font-size: 0.875rem;
  }
}
</style>
