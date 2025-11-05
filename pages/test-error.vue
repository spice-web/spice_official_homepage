<!--
  このページは開発環境専用です
  本番ビルドには含まれません（nuxt.config.tsで設定済み）
-->
<template>
  <div class="test-error-page">
    <div class="container">
      <h1>エラーテストページ</h1>
      <p>以下のボタンでエラーページをテストできます</p>

      <div class="test-buttons">
        <button @click="test404" class="test-btn">
          404エラーをテスト
        </button>

        <button @click="test500" class="test-btn">
          500エラーをテスト
        </button>

        <button @click="test403" class="test-btn">
          403エラーをテスト
        </button>
      </div>

      <div class="test-info">
        <h2>その他のテスト方法</h2>
        <ul>
          <li>存在しないページにアクセス: <code>http://localhost:3000/存在しないページ</code></li>
          <li>存在しないページ例: <NuxtLink to="/this-page-does-not-exist">/this-page-does-not-exist</NuxtLink></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const test404 = () => {
  showError({
    statusCode: 404,
    statusMessage: 'Page Not Found',
    message: 'テスト用の404エラーです'
  })
}

const test500 = () => {
  showError({
    statusCode: 500,
    statusMessage: 'Internal Server Error',
    message: 'テスト用の500エラーです'
  })
}

const test403 = () => {
  showError({
    statusCode: 403,
    statusMessage: 'Forbidden',
    message: 'テスト用の403エラーです'
  })
}
</script>

<style scoped lang="scss">
.test-error-page {
  padding: 4rem 2rem;
  min-height: 100vh;
}

.container {
  max-width: 800px;
  margin: 0 auto;
}

h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
  color: #333;
}

p {
  font-size: 1.1rem;
  margin-bottom: 2rem;
  color: #666;
}

.test-buttons {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 3rem;
}

.test-btn {
  padding: 1rem 2rem;
  font-size: 1rem;
  font-weight: bold;
  background-color: #ea7329;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;

  &:hover {
    background-color: #d46320;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(234, 115, 41, 0.3);
  }
}

.test-info {
  background: #f8f9fa;
  padding: 2rem;
  border-radius: 8px;
  margin-top: 2rem;

  h2 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #333;
  }

  ul {
    list-style: none;
    padding: 0;

    li {
      margin-bottom: 1rem;
      line-height: 1.8;

      code {
        background: #e9ecef;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-family: monospace;
        font-size: 0.9rem;
      }

      a {
        color: #ea7329;
        text-decoration: underline;

        &:hover {
          opacity: 0.8;
        }
      }
    }
  }
}

@media (min-width: 768px) {
  .test-buttons {
    flex-direction: row;
  }
}
</style>
