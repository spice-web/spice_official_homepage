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
      <!-- ECサイト運営 -->
      <BusinessEcShopSection />
      
      <!-- ウェブサイト・ホームページ作成 -->
      <BusinessWebsiteSection />

      <!-- ネットショップ作成サービス -->
      <BusinessNetshopSection />

      <!-- LINE公式アカウント -->
      <BusinessLineSection />

      <!-- DTP・各種印刷物デザイン -->
      <section class="content-section">
        <h2 class="c-headline__lv2">DTP・各種印刷物デザイン</h2>
        <p class="content-section__txt">チラシや冊子、店内POPなどあらゆる印刷物のデザインを承っております。<br>
        制作する物やボリュームによって制作費が異なりますので、お気軽にご相談ください。</p>
        <div class="works_graphic__list list">
          <div class="works_graphic__list__img"><img src="@/assets/images/services/dtp/g_placenta.jpg" alt="プラセンタの力" width="100%"></div>
          <div class="works_graphic__list__img"><img src="@/assets/images/services/dtp/g_rakuda.jpg" alt="ラクーダ" width="100%"></div>
          <div class="works_graphic__list__img"><img src="@/assets/images/services/dtp/g_nyusankin.jpg" alt="乳酸菌応援団" width="100%"></div>
          <div class="works_graphic__list__img"><img src="@/assets/images/services/dtp/g_manjyu.jpg" alt="どじょう掬いまんじゅう" width="100%"></div>
          <div class="works_graphic__list__img"><img src="@/assets/images/services/dtp/g_momo.jpg" alt="農園直送桃" width="100%"></div>
          <div class="works_graphic__list__img"><img src="@/assets/images/services/dtp/g_ginger.jpg" alt="生姜の力" width="100%"></div>
        </div>
      </section>

      <!-- 2カラム -->
       <div class="otherWorks-box">
        <!-- QRコード決済サービス -->
         <section class="content-section">
          <h2 class="c-headline__lv2">QRコード決済サービス</h2>
          <p class="content-section__txt">主要なスマートフォン決済サービスに１台で対応！QRコード決済は、インバウンド需要だけでなく、国内でも急速に普及が進んでいます。お気軽にご相談ください。</p>
          <NuxtLink to="https://spice-web.jp/qrlp/">
            <img src="@/assets/images/services/other/pay.jpg" alt="QRコード決済サービス" width="100%">
          </NuxtLink>
        </section>
        <!-- ポイントカード  CNポイント代理店 -->
        <section class="content-section">
          <h2 class="c-headline__lv2">ポイントカード  CNポイント代理店</h2>
          <p class="content-section__txt">レストラン、アパレルショップ、美容室など、ポイントを活用した販売戦略のお手伝いをおこなっております。ポイントのチャージや、スピーディーなお会計も可能に。</p>
          <NuxtLink to="https://spice-web.jp/cn_point.html">
            <img src="@/assets/images/services/other/clubnets.jpg" alt="QRコード決済サービス" width="100%">
          </NuxtLink>
        </section>
        <!-- 洗浄剤CODE販売店 -->
        <section class="content-section">
          <h2 class="c-headline__lv2">洗浄剤CODE販売店</h2>
          <p class="content-section__txt">CODEとは、溶剤の代替品となり、有機物（油・タンパク質汚れ・ニオイ）を分解できる洗浄剤でありながら、経口毒性・除菌かレベルからみても安全・安心をお届けできる「トータル洗浄剤」です。</p>
          <img src="@/assets/images/services/other/ss_code.jpg" alt="QRコード決済サービス" width="100%">
        </section>

        <!-- 旅行業支援システム・アシスト業務 -->
        <section class="content-section">
          <h2 class="c-headline__lv2">旅行業支援システム・アシスト業務</h2>
          <p class="content-section__txt">旅サポとは、旅行会社、交通、地域をマッチングさせ、快適な旅行を提案するシステムです。団体客の受け入れや、お土産物の企画提案など、物資の手配からシステム面まで支援することにより業務の効率化とサービスの向上に寄与しています。</p>
          <img src="@/assets/images/services/other/ss_tabi.jpg" alt="QRコード決済サービス" width="100%">
        </section>
       </div>
    </div>
  </div>
</template>

<script setup lang="ts">
useHead({
  title: '事業・サービス | 広島のweb・DTP制作会社 株式会社スパイス',
  meta: [
    { name: 'description', content: '株式会社スパイスの事業・サービス紹介ページ。楽天・YAHOOO・amazon等ECサイトの運営やwebサイト制作・DTP・各種印刷物デザイン、QRコード決済サービス、CNポイントサービス導入のお手伝いまでおこなっております。' }
  ]
})

const breadcrumbItems = [
  { label: '事業・サービス' }
]
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

.content-section {
  margin-bottom: 3rem;
}

.content-section h2 {
  // font-size: 1.75rem;
  margin-bottom: 1rem;
}

// セクションの説明
.content-section__txt {
  font-size: 1rem;
  margin-bottom: 2rem;
  color: var(--color-primary);
}

.content-section p {
  line-height: 1.8;
  color: var(--color-secondary);
}



.works_graphic__list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 1rem;

  &__img {
    text-align: center;
    img {
      max-width: 100%;
      height: auto;
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
  }
}

// その他の事業・サービス
.otherWorks-box {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@include responsive($breakpoint-md) {
  .otherWorks-box {
    grid-template-columns: 1fr 1fr;
  }
}
</style>
