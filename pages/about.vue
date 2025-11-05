<template>
  <div class="page">
    <div class="l-header-page">
      <div class="container">
        <h1 class="l-header-page__title">
          Company
          <span>会社概要</span>
        </h1>
      </div>
    </div>
    <Breadcrumb :items="breadcrumbItems" />

    <div class="container">
      <section class="content-section">
        <table class="info-table about_table">
          <tbody>
            <tr>
              <th>会社名</th>
              <td>株式会社スパイス</td>
            </tr>
            <tr>
              <th>代表者</th>
              <td>藤村 智彦</td>
            </tr>
            <tr>
              <th>所在地</th>
              <td oncopy="return false">〒733-0031 広島市西区観音町13番9号</td>
            </tr>
            <tr>
              <th>TEL</th>
              <td oncopy="return false" class="about_table--tel">
                <a href="tel:0822090601">こちらからお願いします。</a>
              </td>
            </tr>
            <tr>
              <th>FAX</th>
              <td oncopy="return false">082-209-0602</td>
            </tr>
            <tr>
              <th>設立</th>
              <td>2008年1月17日</td>
            </tr>
            <tr>
              <th>受付時間</th>
              <td>平日9:00～18:00</td>
            </tr>
            <tr>
              <th>事業内容</th>
              <td>
                <ul>
                  <li>商品開発・コンサルティング</li>
                  <li>ホームページ制作</li>
                  <li>DTP制作</li>
                  <li>ショッピングモール・ECサイト運営管理</li>
                  <li>化粧品OEM</li>
                  <li>洗浄剤CODE販売店</li>
                  <li>ポイント事業　CN加盟店</li>
                  <li>旅行業支援システム、アシスト業務</li>
                </ul>
              </td>
            </tr>
            <tr>
              <th>サイトURL</th>
              <td oncopy="return false">
                <a href="https://spice-web.jp">https://spice-web.jp</a>
              </td>
            </tr>
            <tr>
              <th>アドレス</th>
              <td oncopy="return false">info<span class="spamCheck"></span>spice-web.jp
              </td>
            </tr>
          </tbody>
        </table>
      </section>

      <section class="content-section">
        <h2 class="section-title">アクセス</h2>
        <div class="map-container">
          <iframe
            src="https://www.google.com/maps?q=広島県広島市西区観音町13-9&output=embed"
            width="100%"
            height="450"
            style="border:0;"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
const breadcrumbItems = [
  { label: '会社概要' }
]

useHead({
  title: '会社概要 | 広島のweb・DTP制作会社 株式会社スパイス',
  meta: [
    { name: 'description', content: '株式会社スパイスの会社概要ページです。株式会社スパイスは、広島を拠点としてマーケティング・コンサルティングを得意とし、集客に強いサイト制作まで一貫して行っています。御社のターゲットユーザーを集客し、企画力とユーザビリティの高いデザインによって売上アップに貢献します。' }
  ]
})
</script>

<style scoped>
.content-section {
  margin-bottom: 3rem;
}

.section-title {
  font-size: 1.75rem;
  margin-bottom: 1.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid var(--color-primary, #007bff);
}

.map-container {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
  /* border-radius: 8px; */
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.info-table {
  width: 100%;
  border-collapse: collapse;
}

.info-table th,
.info-table td {
  padding: 1rem;
  border-bottom: 1px solid var(--color-border);
  text-align: left;
}

.info-table th {
  background-color: #f8f9fa;
  font-weight: bold;
  width: 200px;
  vertical-align: top;
}

.info-table td ul {
  margin: 0;
  padding-left: 1.5rem;
  list-style-type: disc;
}

.info-table td ul li {
  margin-bottom: 0.5rem;
}

.info-table td ul li:last-child {
  margin-bottom: 0;
}

.info-table a {
  color: var(--color-primary, #007bff);
  text-decoration: none;
}

.info-table a:hover {
  text-decoration: underline;
}


@media (max-width: 767px) {
  .section-title {
    font-size: 1.5rem;
  }

  .info-table th {
    width: 100px;
  }

  .info-table th,
  .info-table td {
    display: block;
    width: 100%;
  }

  .info-table th {
    padding-bottom: 0.5rem;
  }

  .info-table td {
    padding-top: 0.5rem;
  }

  .map-container iframe {
    height: 300px;
  }
}
</style>
