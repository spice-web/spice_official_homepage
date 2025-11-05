<template>
  <div class="page">
    <div class="l-header-page">
      <div class="container">
        <h1 class="l-header-page__title">
          Contact
          <span>お問い合わせ</span>
        </h1>
      </div>
    </div>
    <Breadcrumb :items="breadcrumbItems" />

    <div class="container">
      <section class="thanks-section">
        <div class="thanks-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
        </div>

        <h2 class="thanks-title">送信完了</h2>

        <div class="thanks-message">
          <p>お問い合わせいただき、誠にありがとうございます。</p>
          <p>ご入力いただいた内容を確認の上、担当者より折り返しご連絡させていただきます。</p>
          <p>今しばらくお待ちくださいませ。</p>
        </div>

        <div class="thanks-note">
          <p class="note-title">※ご確認ください</p>
          <ul class="note-list">
            <li>お問い合わせ内容の確認メールが自動で送信されます。</li>
            <li>メールが届かない場合は、迷惑メールフォルダをご確認ください。</li>
            <li>3営業日以内にご返信がない場合は、お手数ですが再度お問い合わせください。</li>
          </ul>
        </div>

        <div class="thanks-actions">
          <NuxtLink to="/" class="btn-primary">
            トップページへ戻る
          </NuxtLink>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
// お問い合わせフォームから来た場合のみアクセスを許可
onMounted(() => {
  // セッションストレージをチェック
  const hasSubmitted = sessionStorage.getItem('contactFormSubmitted')
  
  if (!hasSubmitted) {
    // フォームから来ていない場合はお問い合わせページにリダイレクト
    navigateTo('/contact', { replace: true })
    return
  }

  // アクセス後はフラグを削除（リロード防止）
  sessionStorage.removeItem('contactFormSubmitted')
})

const breadcrumbItems = [
  { label: 'お問い合わせ', path: '/contact' },
  { label: '送信完了' }
]

useHead({
  title: 'お問い合わせ送信完了 | 広島のweb・DTP制作会社 株式会社スパイス',
  meta: [
    { name: 'description', content: 'お問い合わせありがとうございました。担当者より折り返しご連絡させていただきます。' },
    { name: 'robots', content: 'noindex, nofollow, noarchive, nosnippet' },
    { property: 'robots', content: 'noindex, nofollow, noarchive, nosnippet' }
  ]
})
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

.thanks-section {
  max-width: 700px;
  margin: 3rem auto;
  padding: 3rem 1rem;
  text-align: center;
}

.thanks-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto 2rem;

  svg {
    width: 100%;
    height: 100%;
    color: #28a745;
  }
}

.thanks-title {
  font-size: 2rem;
  font-weight: bold;
  color: var(--color-primary);
  margin-bottom: 2rem;
}

.thanks-message {
  margin-bottom: 3rem;

  p {
    font-size: 1rem;
    line-height: 1.8;
    color: #333;
    margin-bottom: 1rem;
  }
}

.thanks-note {
  background-color: #f8f9fa;
  border-left: 4px solid var(--color-primary);
  padding: 1.5rem;
  text-align: left;
  margin-bottom: 3rem;
}

.note-title {
  font-weight: bold;
  font-size: 0.875rem;
  color: var(--color-primary);
  margin-bottom: 1rem;
}

.note-list {
  list-style: none;
  padding: 0;

  li {
    font-size: 0.875rem;
    line-height: 1.8;
    color: #666;
    padding-left: 1.5rem;
    position: relative;
    margin-bottom: 0.5rem;

    &::before {
      content: "・";
      position: absolute;
      left: 0.5rem;
    }
  }
}

.thanks-actions {
  margin-top: 3rem;
}

.btn-primary {
  display: inline-block;
  padding: 1rem 3rem;
  background-color: var(--color-primary);
  color: white;
  text-decoration: none;
  border-radius: 4px;
  font-weight: bold;
  transition: all 0.3s ease;

  &:hover {
    opacity: 0.8;
    transform: translateY(-2px);
  }
}

@include responsive($breakpoint-md) {
  .thanks-section {
    padding: 4rem 2rem;
  }

  .thanks-title {
    font-size: 2.5rem;
  }
}
</style>
