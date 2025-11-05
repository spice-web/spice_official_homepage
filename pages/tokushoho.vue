<template>
  <div class="page">
    <div class="l-header-page">
      <div class="container">
        <h1 class="l-header-page__title">
          Legal Notice
          <span>特定商取引法に基づく表記</span>
        </h1>
      </div>
    </div>
    <Breadcrumb :items="breadcrumbItems" />

    <div class="container">
      <section class="content-section">
        <table class="info-table">
          <tbody>
            <tr>
              <th>販売業者</th>
              <td>株式会社スパイス</td>
            </tr>
            <tr>
              <th>運営統括責任者名</th>
              <td>藤村 智彦</td>
            </tr>
            <tr>
              <th>所在地</th>
              <td>〒733-0031<br>広島県広島市西区観音町13-9</td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>082-209-0601</td>
            </tr>
            <tr>
              <th>公開メールアドレス</th>
              <td><span class="spamCheck"></span></td>
            </tr>
            <tr>
              <th>販売価格</th>
              <td>各商品ページに記載の金額</td>
            </tr>
            <tr>
              <th>商品代金以外の料金の説明</th>
              <td>各商品ページにてご確認ください。</td>
            </tr>
            <tr>
              <th>追加手数料等の追加料金</th>
              <td>
                会員サイトの有料会員の場合：なし<br>
                通信販売：各商品ページにてご確認ください。
              </td>
            </tr>
            <tr>
              <th>受け付け可能な決済手段</th>
              <td>クレジットカード</td>
            </tr>
            <tr>
              <th>決済期間</th>
              <td>クレジットカード決済の場合はただちに処理されます</td>
            </tr>
            <tr>
              <th>引渡し時期</th>
              <td>ご注文を受けて1～3営業日以内に発送</td>
            </tr>
            <tr>
              <th>申込有効期限</th>
              <td>ご注文後7日以内といたします。ご注文後7日間ご入金がない場合は、購入の意思がないものとし、注文を自動的にキャンセルとさせていただきます。</td>
            </tr>
            <tr>
              <th>販売数量</th>
              <td>各商品ページにてご確認ください。</td>
            </tr>
            <tr>
              <th>交換および返品（返金ポリシー）</th>
              <td>
                <div class="return-policy">
                  <h4>お客様都合の返品・交換の場合</h4>
                  <p><strong>発送処理前の商品：</strong>ウェブサイトのキャンセルボタンを押すことで注文のキャンセルが可能です。</p>
                  <p><strong>発送処理後の商品：</strong>未開封の商品は、商品到着後5日以内にお客様サポートセンター（電話番号：082-209-0601）にご連絡いただいた場合に限り、お客様の送料負担にて返金いたします。開封後の商品は、返品・交換はお受けしておりません。</p>

                  <h4>商品に不備がある場合</h4>
                  <p>当社の送料負担にて返金又は新しい商品と交換いたします。まずはお客様サポートセンター（電話番号：082-209-0601）までご連絡ください。</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
const breadcrumbItems = [
  { label: '特定商取引法に基づく表記' }
]

useHead({
  title: '特定商取引法に基づく表記 | 広島のweb・DTP制作会社 株式会社スパイス',
  meta: [
    { name: 'description', content: '株式会社スパイスの特定商取引法に基づく表記です。' }
  ]
})
</script>

<style scoped>
.content-section {
  max-width: 900px;
  margin: 0 auto 3rem;
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
  vertical-align: top;
}

.info-table th {
  background-color: #f8f9fa;
  font-weight: bold;
  width: 250px;
}

.info-table td {
  line-height: 1.7;
}

.spamCheck::before {
  content: 'info@spice-web.jp';
}

.return-policy {
  h4 {
    font-size: 1rem;
    font-weight: bold;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    color: #333;

    &:first-child {
      margin-top: 0;
    }
  }

  p {
    margin-bottom: 0.75rem;
    line-height: 1.7;

    strong {
      color: #ea7329;
    }
  }
}

@media (max-width: 767px) {
  .content-section {
    max-width: 100%;
  }

  .info-table th {
    width: 100px;
    font-size: 0.875rem;
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
    font-size: 0.875rem;
  }

  .return-policy h4 {
    font-size: 0.9375rem;
  }
}
</style>
