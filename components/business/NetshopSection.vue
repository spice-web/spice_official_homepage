<template>
  <section class="content-section p-netshop">
    <h2 class="c-headline__lv2">ネットショップ作成サービス</h2>
    <p class="content-section__txt">
      各種ネットショップ作成プラットフォームの構築・運用をサポートいたします。<br>
      お客様のビジネスに最適なプラットフォームをご提案し、開設から運用まで一貫してサポートします。
    </p>

    <div class="p-netshop__logo-list">
      <div
        v-for="platform in platforms"
        :key="platform.name"
        class="p-netshop__logo-item"
      >
        <div class="p-netshop__logo-wrapper">
          <img
            v-if="platform.logo"
            :src="platform.logo"
            :alt="platform.name"
            class="p-netshop__logo-image"
          >
          <div v-else class="p-netshop__logo-placeholder">
            {{ platform.name }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
// 画像をインポート
import makeshopLogo from '@/assets/images/platforms/makeshop_logo.webp'
import shopifyLogo from '@/assets/images/platforms/shopify_logo.png'
import baseLogo from '@/assets/images/platforms/base_logo.png'
import shopserveLogo from '@/assets/images/platforms/shopserve_logo.png'
import eccubeLogo from '@/assets/images/platforms/eccube_logo.png'

interface Platform {
  name: string
  logo?: string
}

const platforms: Platform[] = [
  {
    name: 'MakeShop',
    logo: makeshopLogo
  },
  {
    name: 'Shopify',
    logo: shopifyLogo
  },
  {
    name: 'BASE',
    logo: baseLogo
  },
  {
    name: 'ショップサーブ',
    logo: shopserveLogo
  },
  {
    name: 'EC-CUBE',
    logo: eccubeLogo
  }
]
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

// =============================================
// Project: ネットショップサービスセクション
// =============================================
.p-netshop {
  margin-bottom: 3rem;

  &__logo-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
  }

  &__logo-item {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  &__logo-wrapper {
    width: 100%;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    // border: 1px solid var(--color-border);
    // border-radius: 8px;
    padding: 1rem;
    transition: transform 0.3s, box-shadow 0.3s;

    &:hover {
      transform: translateY(-4px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
  }

  &__logo-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
  }

  &__logo-placeholder {
    font-size: 1rem;
    font-weight: bold;
    color: var(--color-primary);
    text-align: center;
  }
}

// タブレット以上
@include responsive($breakpoint-md) {
  .p-netshop {
    &__logo-list {
      grid-template-columns: repeat(5, 1fr);
    }
  }
}
</style>
