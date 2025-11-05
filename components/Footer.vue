<template>
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <NuxtLink to="/" class="company-name">
          <img src="@/assets/images/logo.svg" alt="" width="100%" height="auto">
        </NuxtLink>
        <div class="company-info">
          <p class="company_name">株式会社スパイス</p>
          <div class="company-info__details">
            <ul>
              <li class="company-info__list"><span class="zip">〒733-0031</span><br class="pc_br">広島県広島市西区観音町13番9号</li>
              <li class="company-info__list">
                <ul class="phone">
                  <li oncopy="return false;" class="">TEL：<a href="tel:0822090601">こちらからお願いします。</a></li>
                  <li oncopy="return false;">FAX：082-209-0602</li>
                </ul>
              </li>
              <li class="company-info__list">MAIL：<span class="spamCheck">info</span>spice-web.jp</li>
            </ul>
          </div>
        </div>
        <ul class="footer-nav-list">
          <li v-for="item in mainLinks" :key="item.path">
            <NuxtLink :to="item.path" class="footer-link">
              {{ item.label }}
            </NuxtLink>
          </li>
          <li v-for="item in infoLinks" :key="item.path">
            <NuxtLink :to="item.path" class="footer-link">
              {{ item.label }}
            </NuxtLink>
          </li>
        </ul>
      </div>
      <div class="footer-bottom">
        <p class="copyright">&copy; {{ currentYear }} SPICE. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
const currentYear = new Date().getFullYear()

// メインナビゲーションリンク
const mainLinks = [
  { path: '/', label: 'トップページ' },
  { path: '/business', label: '事業内容' },
  { path: '/products', label: '商品開発&販売' },
  { path: '/news', label: '新着情報' },
  { path: '/about', label: '会社概要' },
  { path: '/contact', label: 'お問い合わせ' }
]

// インフォメーションリンク
const infoLinks = [
  { path: '/privacy', label: 'プライバシーポリシー' },
  { path: '/tokushoho', label: '特商法に基づく表記' },
  { path: '/sitemap', label: 'サイトマップ' }
]
</script>

<style scoped lang="scss">
.footer {
  background-color: #000;
  padding: 3rem 0 2rem;
  margin-top: 4rem;
  border-top: 1px solid var(--color-border);
  color: white;
}

.footer-content {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.footer-nav {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
}

.footer-nav-section {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.footer-nav-title {
  font-size: 1rem;
  font-weight: bold;
  color: #ea7329;
  margin: 0;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid rgba(234, 115, 41, 0.3);
}

.footer-nav-list {
  list-style: none;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: repeat(5, 1fr);
  gap: 0.75rem;
  padding: 0;
  margin: 0;
  grid-auto-flow: column;
}

.footer-link {
  color: #fff;
  font-size: 0.875rem;
  text-decoration: none;
  transition: color 0.3s;

  &:hover {
    color: #ea7329;
  }
}

.company-info {
  ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  &__list {
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    line-height: 1.6;
  }

  &__details {
    margin-top: 1rem;
  }
}

.company-name {
  font-weight: bold;
  font-size: 1.125rem;
  max-width: 200px;
  font-size: 1.125rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

.phone {
  list-style: none;
  padding: 0;
  margin: 0;

  li {
    margin-bottom: 0.25rem;
  }

  a {
    color: #fff;
    text-decoration: none;

    &:hover {
      color: #ea7329;
    }
  }
}

.spamCheck::after {
  content: '@';
}

.footer-bottom {
  margin-top: 3rem;
  padding-top: 2rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.copyright {
  text-align: center;
  font-size: 0.875rem;
  color: rgba(255, 255, 255, 0.7);
}

/* モバイル */
@media (max-width: 767px) {
  .footer-nav {
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .company-name {
    max-width: 150px;
  }
}

/* タブレット以上 */
@media (min-width: 768px) {
  .footer-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 0;
    margin-bottom: 3rem;
  }

  .company-name {
    padding-right: 2rem;
    margin-right: 2rem;
    border-right: 1px solid rgba(255, 255, 255, 1);
    margin-bottom: 0;
  }

  .footer-nav {
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
  }
}

/* PC以上 */
@media (min-width: 1024px) {
  .footer-content {
    grid-template-columns: 200px 1fr auto;
  }
}
</style>
