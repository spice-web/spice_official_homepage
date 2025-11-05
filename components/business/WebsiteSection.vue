<template>
  <section class="content-section p-website">
    <h2 class="c-headline__lv2">ウェブサイト・ホームページ作成</h2>
    <p class="content-section__txt">
      ウェブサイト・ホームページの作成を承っております。<br>
      制作する物やボリュームによって制作費が異なりますので、お気軽にご相談ください。
    </p>

    <!-- microCMSから取得したサイト制作一覧 -->
    <div v-if="siteProductionData && siteProductionData.contents && siteProductionData.contents.length > 0" class="cms-content-list">
      <NuxtLink
        v-for="item in siteProductionData.contents"
        :key="item.id"
        :to="`/business/${item.id}`"
        class="cms-content-item"
      >
        <h4 class="cms-content-subtitle">{{ item.title }}様</h4>
        <img
          v-if="item.thumbnail"
          :src="item.thumbnail.url"
          :alt="item.title"
          class="cms-content-thumbnail"
          id="thumbnail"
        >
        <h3 class="cms-content-title">{{ item.title }}様</h3>
      </NuxtLink>
    </div>
  </section>
</template>

<script setup lang="ts">
// microCMSからサイト制作一覧を取得
const { data: siteProductionData } = await useAsyncData('site-production', async () => {
  return await useSiteProduction()
})
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

// =============================================
// Project: ウェブサイト制作セクション
// =============================================
.p-website {
  margin-bottom: 3rem;
}

// =============================================
// Component: CMSコンテンツリスト
// =============================================
.cms-content-list {
  margin-top: 2rem;
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

.cms-content-item {
  display: block;
  margin-bottom: 2rem;
  text-decoration: none;
  transition: transform 0.3s ease, opacity 0.3s ease;

  &:hover {
    transform: translateY(-4px);
    opacity: 1;

    .cms-content-thumbnail {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
  }

  .cms-content-thumbnail {
    width: 100%;
    height: auto;
    border-radius: 4px;
    margin-bottom: 1rem;
    object-fit: cover;
    transition: box-shadow 0.3s ease;
  }

  .cms-content-title {
    font-size: 1rem;
    margin-bottom: 1rem;
    color: var(--color-primary);
    text-align: center;
  }

  .cms-content-subtitle {
    color: #FFF;
    position: absolute;
    top: 38%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.875rem;
    font-weight: normal;
    opacity: 0;
    width: 100%;
    text-align: center;
  }
}

// タブレット以上
@include responsive($breakpoint-md) {
  .cms-content-list {
    grid-template-columns: 1fr 1fr 1fr;
  }

  .cms-content-item {
    position: relative;

    &::after {
      content: "";
      position: absolute;
      width: 80%;
      height: 80%;
      top: 10%;
      left: 10%;
      opacity: 0;
      transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
      background: rgba(234, 118, 43, 0.9);
    }

    &:hover {
      .cms-content-subtitle {
        opacity: 1;
        z-index: 101;
      }
    }

    &:hover::after {
      left: 0;
      top: 0;
      width: 100%;
      height: auto;
      aspect-ratio: 25 / 14;
      opacity: 1;
    }
  }
}
</style>
