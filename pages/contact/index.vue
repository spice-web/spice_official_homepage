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
      <section class="content-section">
        <p class="form-description">
          お問い合わせは下記フォームよりお願いいたします。<br>
          内容を確認後、担当者よりご連絡させていただきます。
        </p>

        <form class="contact-form" @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="name" class="form-label">お名前<span class="required">必須</span></label>
            <input
              id="name"
              v-model="formData.name"
              type="text"
              class="form-input"
              required
            >
          </div>

          <div class="form-group">
            <label for="kana" class="form-label">ふりがな<span class="required">必須</span></label>
            <input
              id="kana"
              v-model="formData.kana"
              type="text"
              class="form-input"
              :class="{ 'input-error': kanaError }"
              required
              @input="validateKana"
            >
            <p v-if="kanaError" class="error-message">{{ kanaError }}</p>
          </div>

          <div class="form-group">
            <label for="email" class="form-label">メールアドレス<span class="required">必須</span></label>
            <input
              id="email"
              v-model="formData.email"
              type="email"
              class="form-input"
              required
            >
          </div>

          <div class="form-group">
            <label for="postal" class="form-label">郵便番号</label>
            <input
              id="postal"
              v-model="formData.postal"
              type="text"
              class="form-input"
              placeholder="000-0000"
              @input="onPostalCodeInput"
              @blur="searchAddress"
            >
            <p v-if="addressSearching" class="address-status">住所を検索中...</p>
            <p v-if="addressError" class="error-message">{{ addressError }}</p>
          </div>

          <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input
              id="address"
              v-model="formData.address"
              type="text"
              class="form-input"
            >
          </div>

          <div class="form-group">
            <label for="phone" class="form-label">電話番号<span class="required">必須</span></label>
            <input
              id="phone"
              v-model="formData.phone"
              type="tel"
              class="form-input"
              placeholder="00-0000-0000"
              required
            >
          </div>

          <div class="form-group">
            <label for="subject" class="form-label">件名<span class="required">必須</span></label>
            <input
              id="subject"
              v-model="formData.subject"
              type="text"
              class="form-input"
              required
            >
          </div>

          <div class="form-group">
            <label for="inquiry-type" class="form-label">ご用件<span class="required">必須</span></label>
            <select
              id="inquiry-type"
              v-model="formData.inquiryType"
              class="form-input"
              required
            >
              <option value="" selected disabled>選択してください</option>
              <option value="車椅子「ラク～ダ」についてのお問い合わせ">車椅子「ラク～ダ」についてのお問い合わせ</option>
              <option value="その他商品についてのご質問・お問い合わせ">その他商品についてのご質問・お問い合わせ</option>
              <option value="お仕事依頼・お取引に関するお問い合わせ">お仕事依頼・お取引に関するお問い合わせ</option>
              <option value="見積もり・価格に関するお問い合わせ">見積もり・価格に関するお問い合わせ</option>
              <option value="資料請求">資料請求</option>
              <option value="採用・求人に関するお問い合わせ">採用・求人に関するお問い合わせ</option>
              <option value="取材・メディア関係のお問い合わせ">取材・メディア関係のお問い合わせ</option>
              <option value="ご意見・ご要望">ご意見・ご要望</option>
              <option value="アフターサービス・サポート">アフターサービス・サポート</option>
              <option value="納期・在庫に関するお問い合わせ">納期・在庫に関するお問い合わせ</option>
              <option value="展示会・イベントに関するお問い合わせ">展示会・イベントに関するお問い合わせ</option>
              <option value="その他">その他</option>
            </select>
          </div>

          <div class="form-group">
            <label for="message" class="form-label">お問い合わせ内容<span class="required">必須</span></label>
            <textarea
              id="message"
              v-model="formData.message"
              class="form-textarea"
              rows="6"
              required
            ></textarea>
            <p class="form-note">※URLの入力は禁止です。日本語を含めて入力してください。</p>
          </div>

          <div class="form-group privacy-agreement">
            <p class="privacy-text">
              以下の個人情報の取り扱いに関する事項についてご確認いただき、同意いただける方は「同意する」を選択して進んで下さい。
            </p>
            <div class="checkbox-wrapper">
              <input
                id="privacy-agree"
                v-model="formData.privacyAgreed"
                type="checkbox"
                class="privacy-checkbox"
                required
              >
              <label for="privacy-agree" class="checkbox-parts"></label>
              <label for="privacy-agree" class="checkbox-label">
                <NuxtLink to="/privacy" target="_blank" class="privacy-link">プライバシーポリシー</NuxtLink>に同意する<span class="required">必須</span>
              </label>
            </div>
          </div>

          <!-- Cloudflare Turnstile -->
          <div class="form-group turnstile-wrapper">
            <div
              id="turnstile-widget"
              class="cf-turnstile"
            ></div>
            <p v-if="turnstileToken" class="turnstile-debug">✓ セキュリティ認証完了</p>
          </div>

          <div class="form-actions">
            <button type="submit" class="submit-button" :disabled="isSubmitting">
              {{ isSubmitting ? '送信中...' : '送信する' }}
            </button>
          </div>
        </form>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()
const turnstileWidget = ref<HTMLElement | null>(null)
let turnstileToken = ref('')

const breadcrumbItems = [
  { label: 'お問い合わせ' }
]

useHead({
  title: 'お問い合わせ | 広島のweb・DTP制作会社 株式会社スパイス',
  meta: [
    { name: 'description', content: '株式会社スパイスのお問い合わせページです。お気軽にご相談ください。' }
  ],
  script: [
    {
      src: 'https://challenges.cloudflare.com/turnstile/v0/api.js',
      async: true,
      defer: true
    }
  ]
})

const formData = reactive({
  name: '',
  kana: '',
  email: '',
  postal: '',
  address: '',
  phone: '',
  subject: '',
  inquiryType: '',
  message: '',
  privacyAgreed: false
})

const isSubmitting = ref(false)
const kanaError = ref('')
const addressSearching = ref(false)
const addressError = ref('')

// ふりがなバリデーション関数
const validateKana = () => {
  const kana = formData.kana
  
  if (!kana) {
    kanaError.value = ''
    return
  }
  
  // ひらがな、カタカナ、全角スペース、長音符のみ許可
  const kanaPattern = /^[ぁ-んァ-ヶーー\s　]*$/
  
  if (!kanaPattern.test(kana)) {
    kanaError.value = 'ふりがなは、ひらがな・カタカナのみで入力してください'
  } else {
    kanaError.value = ''
  }
}

// 郵便番号入力時の処理
const onPostalCodeInput = () => {
  // エラーメッセージをクリア
  addressError.value = ''
  
  // ハイフンを自動挿入（000-0000形式）
  const value = formData.postal.replace(/[^\d]/g, '')
  if (value.length >= 4) {
    formData.postal = value.slice(0, 3) + '-' + value.slice(3, 7)
  }
}

// 住所検索関数
const searchAddress = async () => {
  const postalCode = formData.postal.replace(/[^\d]/g, '')
  
  // 郵便番号が7桁でない場合は検索しない
  if (postalCode.length !== 7) {
    return
  }
  
  addressSearching.value = true
  addressError.value = ''
  
  try {
    // zipcloud APIを使用して住所を検索
    const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postalCode}`)
    const data = await response.json()
    
    if (data.status === 200 && data.results && data.results.length > 0) {
      const result = data.results[0]
      const fullAddress = `${result.address1}${result.address2}${result.address3}`
      
      // 住所フィールドが空の場合のみ自動入力
      if (!formData.address.trim()) {
        formData.address = fullAddress
      } else {
        // 既に住所が入力されている場合は確認
        if (confirm(`住所を「${fullAddress}」に変更しますか？`)) {
          formData.address = fullAddress
        }
      }
    } else {
      addressError.value = '該当する住所が見つかりませんでした'
    }
  } catch (error) {
    console.error('住所検索エラー:', error)
    addressError.value = '住所の検索に失敗しました'
  } finally {
    addressSearching.value = false
  }
}

// Turnstileコールバック
if (process.client) {
  (window as any).onTurnstileSuccess = (token: string) => {
    console.log('Turnstile success callback called')
    turnstileToken.value = token
    console.log('Token set:', token.substring(0, 20) + '...')
  }
}

// Turnstileウィジェットの初期化
onMounted(() => {
  // Turnstileスクリプトが読み込まれるまで待機
  const initTurnstile = () => {
    if ((window as any).turnstile) {
      console.log('Initializing Turnstile widget...')
      const widgetElement = document.getElementById('turnstile-widget')
      if (widgetElement && config.public.turnstileSiteKey) {
        try {
          (window as any).turnstile.render('#turnstile-widget', {
            sitekey: config.public.turnstileSiteKey,
            callback: (token: string) => {
              turnstileToken.value = token
              console.log('Turnstile token received')
            }
          })
          console.log('Turnstile widget initialized successfully')
        } catch (error) {
          console.error('Failed to initialize Turnstile:', error)
        }
      }
    } else {
      // スクリプトがまだ読み込まれていない場合は、少し待ってから再試行
      setTimeout(initTurnstile, 100)
    }
  }

  // 初期化を実行
  initTurnstile()
})

// Turnstileトークンを手動で取得する関数
const getTurnstileToken = () => {
  if (process.client && (window as any).turnstile) {
    try {
      const response = (window as any).turnstile.getResponse()
      if (response) {
        console.log('Manual token retrieval successful')
        return response
      }
    } catch (e) {
      console.error('Failed to get turnstile token manually:', e)
    }
  }
  return null
}

const handleSubmit = async () => {
  // ふりがなバリデーション
  validateKana()
  if (kanaError.value) {
    alert('ふりがなの入力に問題があります。正しく入力してください。')
    return
  }

  // バリデーション: URLチェック
  if (formData.message.match(/https?:\/\//)) {
    alert('お問い合わせ内容にURLを含めることはできません。')
    return
  }

  // 日本語チェック
  if (!formData.message.match(/[ぁ-んァ-ヶー一-龠]/)) {
    alert('お問い合わせ内容には日本語を含めてください。')
    return
  }

  // プライバシーポリシー同意チェック
  if (!formData.privacyAgreed) {
    alert('プライバシーポリシーに同意してください。')
    return
  }

  // Turnstileトークンチェック（コールバックで取得できなかった場合は手動取得を試行）
  let token = turnstileToken.value
  if (!token) {
    console.log('Token not found in ref, trying manual retrieval...')
    token = getTurnstileToken()
  }

  console.log('Final token check:', token ? 'Token exists' : 'Token missing')

  if (!token) {
    alert('セキュリティ認証を完了してください。ページを再読み込みしてもう一度お試しください。')
    return
  }

  // 送信処理
  isSubmitting.value = true

  try {
    const response = await fetch('/contact-mail.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        ...formData,
        turnstileToken: token
      })
    })

    const result = await response.json()

    if (result.success) {
      // セッションストレージにフラグを設定
      if (process.client) {
        sessionStorage.setItem('contactFormSubmitted', 'true')
      }
      // サンクスページへリダイレクト
      await navigateTo('/contact/thanks')
    } else {
      console.error('Server response:', result)
      let errorMessage = result.message || 'エラーが発生しました。'
      if (result.errors && result.errors.length > 0) {
        console.error('Validation errors:', result.errors)
        errorMessage += '\n\n詳細:\n' + result.errors.join('\n')
      }
      alert(errorMessage)

      // Turnstileウィジェットをリセット
      if (process.client && (window as any).turnstile) {
        (window as any).turnstile.reset()
        turnstileToken.value = ''
        console.log('Turnstile widget reset')
      }
    }
  } catch (error) {
    console.error('送信エラー:', error)
    alert('送信中にエラーが発生しました。しばらく時間をおいて再度お試しください。')

    // Turnstileウィジェットをリセット
    if (process.client && (window as any).turnstile) {
      (window as any).turnstile.reset()
      turnstileToken.value = ''
      console.log('Turnstile widget reset after error')
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

.content-section {
  max-width: 800px;
  margin: 0 auto 3rem;
}

.form-description {
  text-align: left;
  margin-bottom: 3rem;
  line-height: 1.8;
}

@include responsive($breakpoint-md) {
  .form-description {
    text-align: center;
  }
}

.contact-form {
  background-color: #ffffff;
}

.form-group {
  margin-bottom: 2rem;
}

.form-label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.required {
  display: inline-block;
  content: "必須";
  background: #d9534f;
  color: #fff;
  border-radius: 3px;
  font-size: 0.875rem;
  width: 40px;
  text-align: center;
}

.form-input,
.form-textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid var(--color-border);
  border-radius: 4px;
  font-size: 1rem;
  font-family: inherit;
}

.form-input:focus,
.form-textarea:focus {
  outline: none;
  border-color: var(--color-primary);
}

.input-error {
  border-color: #d9534f !important;
  background-color: #fdf2f2;
}

.error-message {
  color: #d9534f;
  font-size: 0.875rem;
  margin-top: 0.25rem;
  margin-bottom: 0;
}

.address-status {
  color: #007bff;
  font-size: 0.875rem;
  margin-top: 0.25rem;
  margin-bottom: 0;
}

.form-textarea {
  resize: vertical;
}

.form-note {
  font-size: 0.875rem;
  color: var(--color-secondary);
  margin-top: 0.5rem;
}

// プライバシー同意セクション
.privacy-text {
  font-size: 0.875rem;
  line-height: 1.6;
  margin-bottom: 1rem;
  color: #333;
}

.checkbox-wrapper {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.privacy-checkbox {
  display: none;
}

.checkbox-parts {
  padding-right: 20px;
  position: relative;
  margin-left: 20px;
  cursor: pointer;

  // チェックボックスの枠
  &::before {
    content: "";
    display: block;
    position: absolute;
    top: -5px;
    right: 0;
    width: 15px;
    height: 15px;
    border: 1px solid #898989;
    background-color: #fff;
    transition: all 0.2s;
  }

  // チェックマーク（デフォルトは非表示）
  &::after {
    content: "";
    display: block;
    position: absolute;
    top: -9px;
    right: 3px;
    width: 7px;
    height: 14px;
    transform: rotate(40deg);
    border-bottom: 3px solid #ea7329;
    border-right: 3px solid #ea7329;
    opacity: 0;
    transition: opacity 0.2s;
  }
}

// チェックされた時にチェックマークを表示
.privacy-checkbox:checked + .checkbox-parts::after {
  opacity: 1;
}

.checkbox-label {
  font-size: 0.875rem;
  cursor: pointer;
  margin-bottom: 0;
  position: relative;
}

.privacy-link {
  color: var(--color-primary, #007bff);
  text-decoration: underline;
}

.privacy-link:hover {
  text-decoration: none;
}

.turnstile-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 1.5rem;
}

.turnstile-debug {
  margin-top: 0.5rem;
  font-size: 0.875rem;
  color: #28a745;
  font-weight: bold;
}

.form-actions {
  text-align: center;
  margin-top: 3rem;
}

// 送信ボタン
.submit-button {
  padding: 1rem 4rem;
  background-color: var(--color-primary);
  color: white;
  border-radius: 4px;
  font-size: 1.125rem;
  font-weight: bold;
  transition: background-color 0.3s;
  cursor: pointer;
}

.submit-button:hover:not(:disabled) {
  background-color: var(--color-secondary);
}

.submit-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
