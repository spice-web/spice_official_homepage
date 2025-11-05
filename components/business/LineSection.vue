<template>
  <section class="content-section p-line">
    <h2 class="c-headline__lv2">LINE公式アカウント導入・運用サポート</h2>
    <div class="p-line__container">
      <div class="p-line__content">
        <p class="content-section__txt">
          LINE公式アカウントの導入から運用サポートまで承っております。<br>
          通常のLINE公式アカウントでは不可能なセグメント配信や月間レポートなど、顧客獲得や客単価アップに繋がる運用サポートや、アンケート、クーポンなどの効果的な利用方法。多店舗展開企業の経費削減もご提案させていただいております。
        </p>
        <img src="@/assets/images/services/direct.jpg" alt="LINE公式アカウント" class="p-line__sub-image">
      </div>
      <figure class="p-line__figure">
        <img src="@/assets/images/services/line_image.jpg" alt="LINE運用サポート" width="100%">
      </figure>
    </div>
  </section>
</template>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

// =============================================
// Project: LINE公式アカウントセクション
// =============================================
.p-line {
  margin-bottom: 3rem;

  &__container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  &__content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  &__sub-image {
    width: 100%;
    height: auto;
  }

  &__figure {
    text-align: center;

    img {
      max-width: 100%;
      height: auto;
    }
  }
}

// タブレット以上
@include responsive($breakpoint-md) {
  .p-line {
    &__container {
      grid-template-columns: 1fr 1fr;
    }
  }
}
</style>
