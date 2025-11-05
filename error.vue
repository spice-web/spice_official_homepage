<template>
  <div class="error-page">
    <div class="container">
      <div class="error-content">
        <div class="error-code">
          {{ error.statusCode }}
        </div>
        
        <h1 class="error-title">
          {{ errorTitle }}
        </h1>
        
        <p class="error-message">
          {{ errorMessage }}
        </p>

        <div class="error-actions">
          <NuxtLink to="/" class="btn-home">
            <span>トップページへ戻る</span>
          </NuxtLink>
          
          <button @click="handleError" class="btn-back">
            前のページへ戻る
          </button>
        </div>
      </div>

      <div class="error-illustration">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 300" class="error-svg">
          <text x="250" y="150" text-anchor="middle" class="error-bg-text">
            {{ error.statusCode }}
          </text>
        </svg>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface ErrorProps {
  error: {
    statusCode: number
    statusMessage?: string
    message?: string
  }
}

const props = defineProps<ErrorProps>()

const errorTitle = computed(() => {
  switch (props.error.statusCode) {
    case 404:
      return 'ページが見つかりません'
    case 500:
      return 'サーバーエラー'
    case 403:
      return 'アクセスが拒否されました'
    default:
      return 'エラーが発生しました'
  }
})

const errorMessage = computed(() => {
  switch (props.error.statusCode) {
    case 404:
      return 'お探しのページは見つかりませんでした。URLが間違っているか、ページが移動または削除された可能性があります。'
    case 500:
      return 'サーバーで問題が発生しました。しばらく時間をおいてから再度お試しください。'
    case 403:
      return 'このページへのアクセス権限がありません。'
    default:
      return props.error.message || '予期しないエラーが発生しました。'
  }
})

const handleError = () => {
  // エラーをクリアしてトップページへリダイレクト
  clearError()
  navigateTo('/')
}

useHead({
  title: `${props.error.statusCode} - ${errorTitle.value}`,
  meta: [
    { name: 'robots', content: 'noindex, nofollow' }
  ]
})
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

.error-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  padding: 2rem;
}

.container {
  max-width: 800px;
  margin: 0 auto;
  position: relative;
}

.error-content {
  text-align: center;
  position: relative;
  z-index: 2;
  background: rgba(255, 255, 255, 0.95);
  padding: 3rem 2rem;
  border-radius: 16px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.error-code {
  font-size: 6rem;
  font-weight: bold;
  color: var(--color-primary);
  line-height: 1;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.error-title {
  font-size: 2rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 1rem;
}

.error-message {
  font-size: 1rem;
  color: #666;
  line-height: 1.8;
  margin-bottom: 2rem;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.error-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-home,
.btn-back {
  padding: 0.875rem 2rem;
  border-radius: 8px;
  font-weight: bold;
  font-size: 1rem;
  transition: all 0.3s ease;
  cursor: pointer;
  border: none;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-home {
  background-color: var(--color-primary);
  color: white;

  &:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }
}

.btn-back {
  background-color: #f8f9fa;
  color: #333;
  border: 2px solid #dee2e6;

  &:hover {
    background-color: #e9ecef;
    transform: translateY(-2px);
  }
}

.error-illustration {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
  height: 100%;
  z-index: 1;
  opacity: 0.1;
  pointer-events: none;
}

.error-svg {
  width: 100%;
  height: 100%;
}

.error-bg-text {
  font-size: 200px;
  font-weight: bold;
  fill: var(--color-primary);
  opacity: 0.3;
}

// レスポンシブ対応
@media (max-width: 768px) {
  .error-code {
    font-size: 4rem;
  }

  .error-title {
    font-size: 1.5rem;
  }

  .error-message {
    font-size: 0.9rem;
  }

  .error-content {
    padding: 2rem 1.5rem;
  }

  .error-actions {
    flex-direction: column;
  }

  .btn-home,
  .btn-back {
    width: 100%;
  }
}
</style>
