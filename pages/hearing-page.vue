<template>
  <div class="wrap">
    <div class="container">
      <h1 class="page-title">WEBサイト要件ヒアリングページ</h1>
      <form>

        <!-- 1. 基本情報 -->
        <div class="form-section">
          <h2>1. 基本情報</h2>
          <div class="form-group">
            <label for="companyName">会社名</label>
            <input
              type="text"
              id="companyName"
              v-model="form.companyName"
              placeholder="例：株式会社〇〇"
            />
          </div>

          <div class="form-group">
            <label for="contactPerson">担当者名</label>
            <input
              type="text"
              id="contactPerson"
              v-model="form.contactPerson"
              placeholder="例：山田 太郎"
            />
          </div>

          <div class="form-group">
            <label for="contactEmail">メールアドレス</label>
            <input
              type="text"
              id="contactEmail"
              v-model="form.contactEmail"
              placeholder="例：yamada@example.co.jp"
            />
          </div>

          <div class="form-group">
            <label for="contactPhone">電話番号</label>
            <input
              type="text"
              id="contactPhone"
              v-model="form.contactPhone"
              placeholder="例：082-000-0000"
            />
          </div>

          <div class="form-group">
            <label for="siteName">WEBサイト名</label>
            <input
              type="text"
              id="siteName"
              v-model="form.siteName"
              placeholder="例：〇〇株式会社コーポレートサイト"
            />
          </div>

          <div class="form-group">
            <label for="siteType">サイトの種類</label>
            <select id="siteType" v-model="form.siteType">
              <option value="">選択してください</option>
              <option value="corporate">コーポレートサイト</option>
              <option value="ec">ECサイト</option>
              <option value="blog">ブログ</option>
              <option value="portfolio">ポートフォリオ</option>
              <option value="landing">ランディングページ</option>
              <option value="service">サービス紹介</option>
              <option value="news">ニュース/メディア</option>
              <option value="community">コミュニティ</option>
              <option value="other">その他</option>
            </select>
          </div>

          <div class="form-group">
            <label for="domainName">ご希望ドメイン</label>
            <input
              type="text"
              id="domainName"
              v-model="form.domainName"
              placeholder="例：example.co.jp"
            />
          </div>

          <div class="form-group">
            <label>新規制作 / リニューアル</label>
            <div class="radio-group">
              <label class="radio-label">
                <input type="radio" v-model="form.projectType" value="new" />
                新規制作
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.projectType" value="renewal" />
                リニューアル
              </label>
            </div>
          </div>

          <div class="form-group" v-if="form.projectType === 'renewal'">
            <label for="currentSiteUrl">現在のサイトURL</label>
            <input
              type="text"
              id="currentSiteUrl"
              v-model="form.currentSiteUrl"
              placeholder="例：https://example.co.jp"
            />
          </div>

          <div class="form-group">
            <label for="launchDate">希望公開時期</label>
            <input
              type="text"
              id="launchDate"
              v-model="form.launchDate"
              placeholder="例：2025年4月ごろ、半年以内、未定"
            />
          </div>

          <div class="form-group">
            <label for="sitePurpose">サイトの目的</label>
            <textarea
              id="sitePurpose"
              v-model="form.sitePurpose"
              placeholder="例：当社の製品・サービスを紹介し、問い合わせや資料請求を増やす"
            ></textarea>
          </div>
        </div>

        <!-- 2. 会社・ブランド情報 -->
        <div class="form-section">
          <h2>2. 会社・ブランド情報</h2>
          <div class="form-group">
            <label for="brandDescription">会社・サービスの概要</label>
            <textarea
              id="brandDescription"
              v-model="form.brandDescription"
              placeholder="例：創業20年の広告制作会社。チラシ・WEB・映像など幅広く対応しており、地域に密着したサービスが強み。"
            ></textarea>
          </div>

          <div class="form-group">
            <label for="uniqueSellingPoints">他社との違い・自社の強み</label>
            <textarea
              id="uniqueSellingPoints"
              v-model="form.uniqueSellingPoints"
              placeholder="例：対応スピードの速さ、地域No.1の実績数、独自開発の〇〇システム"
            ></textarea>
          </div>
        </div>

        <!-- 3. ターゲット情報 -->
        <div class="form-section">
          <h2>3. ターゲット情報</h2>
          <div class="form-group">
            <label for="targetAudience">どんな人に見てほしいか（ターゲット層）</label>
            <textarea
              id="targetAudience"
              v-model="form.targetAudience"
              placeholder="例：広島県内の中小企業の経営者・担当者、WEBサイトの新規制作やリニューアルを検討している方"
            ></textarea>
          </div>

          <div class="form-group">
            <label for="targetNeeds">ターゲットが抱える悩みや求めていること</label>
            <textarea
              id="targetNeeds"
              v-model="form.targetNeeds"
              placeholder="例：今のサイトが古くて問い合わせが来ない、どこに頼めばいいか分からない、費用感が不安"
            ></textarea>
          </div>
        </div>

        <!-- 4. デザイン要件 -->
        <div class="form-section">
          <h2>4. デザイン要件</h2>
          <div class="form-group">
            <label for="designStyle">デザインのイメージ</label>
            <select id="designStyle" v-model="form.designStyle">
              <option value="">選択してください</option>
              <option value="minimal">ミニマル/シンプル</option>
              <option value="corporate">コーポレート/ビジネス</option>
              <option value="creative">クリエイティブ/アーティスティック</option>
              <option value="luxurious">高級感/プレミアム</option>
              <option value="playful">遊び心のある/カジュアル</option>
              <option value="technical">テクニカル/ハイテク</option>
              <option value="natural">自然/オーガニック</option>
              <option value="retro">レトロ/ビンテージ</option>
              <option value="other">その他</option>
            </select>
          </div>

          <div class="form-group">
            <label for="colorScheme">使いたい色・ブランドカラー</label>
            <input
              type="text"
              id="colorScheme"
              v-model="form.colorScheme"
              placeholder="例：コーポレートカラーの青（#0033CC）を基調にしたい"
            />
            <p class="helper-text">
              カラーコード・ロゴの色・イメージする色調など、分かる範囲で記入してください
            </p>
          </div>

          <div class="form-group">
            <label for="moodBoard">参考にしたいサイトURL</label>
            <textarea
              id="moodBoard"
              v-model="form.moodBoard"
              placeholder="例：https://example.com&#10;（「このデザインが好き」「この雰囲気に近づけたい」といったサイトがあれば）"
            ></textarea>
          </div>

          <div class="form-group">
            <label for="competitorSites">競合他社のサイトURL</label>
            <textarea
              id="competitorSites"
              v-model="form.competitorSites"
              placeholder="例：https://competitor.com&#10;（同業他社のサイトがあれば。「こうはなりたくない」という参考としても活用します）"
            ></textarea>
          </div>
        </div>

        <!-- 5. コンテンツ要件 -->
        <div class="form-section">
          <h2>5. コンテンツ要件</h2>
          <div class="form-group">
            <label>必要なページ</label>
            <div
              class="checkbox-group"
              style="
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 10px;
              "
            >
              <label
                v-for="page in sitePagesOptions"
                :key="page"
                class="checkbox-label"
              >
                <input type="checkbox" v-model="form.sitePages" :value="page" />
                {{ page }}
              </label>
            </div>
            <div class="form-group" style="margin-top: 10px">
              <label for="otherSitePages">その他のページ</label>
              <input
                type="text"
                id="otherSitePages"
                v-model="form.otherSitePages"
                placeholder="その他必要なページがあれば入力してください（カンマ区切り）"
              />
            </div>
          </div>

          <div class="form-group">
            <label>必要な機能</label>
            <div
              class="checkbox-group"
              style="
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 10px;
              "
            >
              <label
                v-for="feature in featuresOptions"
                :key="feature"
                class="checkbox-label"
              >
                <input type="checkbox" v-model="form.features" :value="feature" />
                {{ feature }}
              </label>
            </div>
            <div class="form-group" style="margin-top: 10px">
              <label for="otherFeatures">その他の機能</label>
              <input
                type="text"
                id="otherFeatures"
                v-model="form.otherFeatures"
                placeholder="その他必要な機能があれば入力してください（カンマ区切り）"
              />
            </div>
          </div>

          <div class="form-group">
            <label for="callToAction">サイトを通じて訪問者に最終的にしてほしい行動</label>
            <input
              type="text"
              id="callToAction"
              v-model="form.callToAction"
              placeholder="例：問い合わせフォームから相談してほしい、商品を購入してほしい、来店してほしい"
            />
          </div>
        </div>

        <!-- 6. 予算 -->
        <div class="form-section">
          <h2>6. 予算</h2>
          <div class="form-group">
            <label for="budget">おおよその予算感</label>
            <select id="budget" v-model="form.budget">
              <option value="">選択してください</option>
              <option value="under30">〜30万円</option>
              <option value="30to50">30万〜50万円</option>
              <option value="50to100">50万〜100万円</option>
              <option value="100to200">100万〜200万円</option>
              <option value="over200">200万円〜</option>
              <option value="undecided">未定・ご相談</option>
            </select>
            <p class="helper-text">
              予算感によって提案内容が変わります。「未定・ご相談」でも構いません
            </p>
          </div>
        </div>

        <!-- 7. コンテンツ・運用 -->
        <div class="form-section">
          <h2>7. コンテンツ・運用</h2>
          <div class="form-group">
            <label for="contentPreparation">テキスト・写真の準備状況</label>
            <select id="contentPreparation" v-model="form.contentPreparation">
              <option value="">選択してください</option>
              <option value="all-self">テキスト・写真ともに自社で用意する</option>
              <option value="text-self">テキストは自社で用意、写真は制作会社に依頼</option>
              <option value="photo-self">写真は自社で用意、テキストは制作会社に依頼</option>
              <option value="all-outsource">テキスト・写真ともに制作会社に依頼したい</option>
              <option value="undecided">未定</option>
            </select>
          </div>

          <div class="form-group">
            <label for="updateMethod">公開後の更新方法</label>
            <select id="updateMethod" v-model="form.updateMethod">
              <option value="">選択してください</option>
              <option value="cms">自分たちで更新できるようにしたい（CMS希望）</option>
              <option value="outsource">更新は都度制作会社に依頼する</option>
              <option value="undecided">未定</option>
            </select>
          </div>

          <div class="form-group">
            <label for="updateFrequency">更新頻度（予定）</label>
            <select id="updateFrequency" v-model="form.updateFrequency">
              <option value="">選択してください</option>
              <option value="rarely">ほぼ更新しない</option>
              <option value="monthly">月1〜2回程度</option>
              <option value="weekly">週1回程度</option>
              <option value="daily">週数回以上</option>
              <option value="undecided">未定</option>
            </select>
          </div>
        </div>

        <!-- 8. 技術要件 -->
        <div class="form-section">
          <h2>8. 技術要件</h2>
          <div class="form-group">
            <label>対応するデバイス</label>
            <div class="checkbox-group">
              <label
                v-for="size in screenSizeOptions"
                :key="size"
                class="checkbox-label"
              >
                <input type="checkbox" v-model="form.screenSize" :value="size" />
                {{ size }}
              </label>
            </div>
          </div>

          <div class="form-group">
            <label for="specialFeatures">その他、必要な機能・システム</label>
            <textarea
              id="specialFeatures"
              v-model="form.specialFeatures"
              placeholder="例：多言語対応、外部システムとの連携、既存データの移行など"
            ></textarea>
          </div>
        </div>

        <!-- 9. その他 -->
        <div class="form-section">
          <h2>9. その他ご要望・気になること</h2>
          <div class="form-group">
            <label for="additionalInfo">自由記入</label>
            <textarea
              id="additionalInfo"
              v-model="form.additionalInfo"
              placeholder="例：絶対に使いたいキャッチコピーがある、このような表現は避けてほしい、特に強調したいことなど、何でもお書きください"
            ></textarea>
          </div>
        </div>

        <div class="btn-container">
          <button type="button" class="btn" @click="displayOutput">
            入力内容を表示
          </button>
        </div>
      </form>

      <div ref="outputSectionRef" class="output-container" v-show="showOutput">
        <h3>入力内容一覧</h3>
        <div id="outputContent">
          <div
            v-for="section in outputSections"
            :key="section.title"
            class="output-item"
          >
            <h4>{{ section.title }}</h4>
            <template v-for="field in section.fields" :key="field.label">
              <strong>{{ field.label }}: </strong>
              <p>{{ field.value }}</p>
            </template>
          </div>
        </div>
        <div class="btn-container" style="margin-top: 15px">
          <button class="btn" @click="copyOutput">内容をコピー</button>
        </div>
        <div class="turnstile-wrapper">
          <div id="turnstile-widget-hearing" class="cf-turnstile"></div>
          <p v-if="turnstileToken" class="turnstile-verified">✓ セキュリティ認証完了</p>
        </div>
        <div class="btn-container" style="margin-top: 15px">
          <button class="btn" :disabled="isSending" @click="sendEmail">
            {{ isSending ? '送信中...' : 'メールを送る' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref, computed, nextTick, onMounted } from 'vue'

const config = useRuntimeConfig()

const sitePagesOptions = [
  'トップページ',
  '会社概要',
  'サービス紹介',
  '製品紹介',
  '導入事例・実績',
  'ブログ・ニュース',
  '採用情報',
  'お問い合わせ',
  'プライバシーポリシー',
  '利用規約',
  'FAQ・よくある質問',
  '料金・プラン',
]

const featuresOptions = [
  'お問い合わせフォーム',
  'スライダー/カルーセル',
  '画像ギャラリー',
  '動画コンテンツ',
  '料金シミュレーター',
  'アクセスマップ',
  'SNSフィード連携',
  '会員ログイン機能',
  '検索機能',
  '予約/申込みフォーム',
  '資料ダウンロード',
  'お知らせ・新着情報',
  'ECカート/決済機能',
  'サイト内チャット',
]

const screenSizeOptions = ['デスクトップ', 'タブレット', 'モバイル']

const siteTypeLabels: Record<string, string> = {
  corporate: 'コーポレートサイト',
  ec: 'ECサイト',
  blog: 'ブログ',
  portfolio: 'ポートフォリオ',
  landing: 'ランディングページ',
  service: 'サービス紹介',
  news: 'ニュース/メディア',
  community: 'コミュニティ',
  other: 'その他',
}

const designStyleLabels: Record<string, string> = {
  minimal: 'ミニマル/シンプル',
  corporate: 'コーポレート/ビジネス',
  creative: 'クリエイティブ/アーティスティック',
  luxurious: '高級感/プレミアム',
  playful: '遊び心のある/カジュアル',
  technical: 'テクニカル/ハイテク',
  natural: '自然/オーガニック',
  retro: 'レトロ/ビンテージ',
  other: 'その他',
}

const budgetLabels: Record<string, string> = {
  under30: '〜30万円',
  '30to50': '30万〜50万円',
  '50to100': '50万〜100万円',
  '100to200': '100万〜200万円',
  over200: '200万円〜',
  undecided: '未定・ご相談',
}

const contentPreparationLabels: Record<string, string> = {
  'all-self': 'テキスト・写真ともに自社で用意する',
  'text-self': 'テキストは自社で用意、写真は制作会社に依頼',
  'photo-self': '写真は自社で用意、テキストは制作会社に依頼',
  'all-outsource': 'テキスト・写真ともに制作会社に依頼したい',
  undecided: '未定',
}

const updateMethodLabels: Record<string, string> = {
  cms: '自分たちで更新できるようにしたい（CMS希望）',
  outsource: '更新は都度制作会社に依頼する',
  undecided: '未定',
}

const updateFrequencyLabels: Record<string, string> = {
  rarely: 'ほぼ更新しない',
  monthly: '月1〜2回程度',
  weekly: '週1回程度',
  daily: '週数回以上',
  undecided: '未定',
}

const form = reactive({
  // 基本情報
  companyName: '',
  contactPerson: '',
  contactEmail: '',
  contactPhone: '',
  siteName: '',
  siteType: '',
  domainName: '',
  projectType: '',
  currentSiteUrl: '',
  launchDate: '',
  sitePurpose: '',
  // 会社・ブランド情報
  brandDescription: '',
  uniqueSellingPoints: '',
  // ターゲット情報
  targetAudience: '',
  targetNeeds: '',
  // デザイン要件
  designStyle: '',
  colorScheme: '',
  moodBoard: '',
  competitorSites: '',
  // コンテンツ要件
  sitePages: ['トップページ'] as string[],
  otherSitePages: '',
  features: [] as string[],
  otherFeatures: '',
  callToAction: '',
  // 予算
  budget: '',
  // コンテンツ・運用
  contentPreparation: '',
  updateMethod: '',
  updateFrequency: '',
  // 技術要件
  screenSize: ['デスクトップ', 'タブレット', 'モバイル'] as string[],
  specialFeatures: '',
  // その他
  additionalInfo: '',
})

const showOutput = ref(false)
const isSending = ref(false)
const turnstileToken = ref('')
const outputSectionRef = ref<HTMLElement | null>(null)

useHead({
  meta: [
    { name: 'robots', content: 'noindex, nofollow' },
  ],
  script: [
    {
      src: 'https://challenges.cloudflare.com/turnstile/v0/api.js',
      async: true,
      defer: true,
    },
  ],
})

onMounted(() => {
  const initTurnstile = () => {
    if ((window as any).turnstile) {
      const widgetElement = document.getElementById('turnstile-widget-hearing')
      if (widgetElement && config.public.turnstileSiteKey) {
        try {
          (window as any).turnstile.render('#turnstile-widget-hearing', {
            sitekey: config.public.turnstileSiteKey,
            callback: (token: string) => {
              turnstileToken.value = token
            },
          })
        } catch (error) {
          console.error('Failed to initialize Turnstile:', error)
        }
      }
    } else {
      setTimeout(initTurnstile, 100)
    }
  }
  initTurnstile()
})

const outputSections = computed(() => {
  const allSitePages = [...form.sitePages]
  if (form.otherSitePages) {
    form.otherSitePages.split(',').forEach((page) => {
      const trimmed = page.trim()
      if (trimmed) allSitePages.push(trimmed)
    })
  }

  const allFeatures = [...form.features]
  if (form.otherFeatures) {
    form.otherFeatures.split(',').forEach((f) => {
      const trimmed = f.trim()
      if (trimmed) allFeatures.push(trimmed)
    })
  }

  const sections = [
    {
      title: '1. 基本情報',
      fields: [
        { label: '会社名', value: form.companyName },
        { label: '担当者名', value: form.contactPerson },
        { label: 'メールアドレス', value: form.contactEmail },
        { label: '電話番号', value: form.contactPhone },
        { label: 'WEBサイト名', value: form.siteName },
        { label: 'サイトの種類', value: siteTypeLabels[form.siteType] || '' },
        { label: 'ご希望ドメイン', value: form.domainName },
        { label: '新規制作 / リニューアル', value: form.projectType === 'new' ? '新規制作' : form.projectType === 'renewal' ? 'リニューアル' : '' },
        { label: '現在のサイトURL', value: form.currentSiteUrl },
        { label: '希望公開時期', value: form.launchDate },
        { label: 'サイトの目的', value: form.sitePurpose },
      ],
    },
    {
      title: '2. 会社・ブランド情報',
      fields: [
        { label: '会社・サービスの概要', value: form.brandDescription },
        { label: '他社との違い・自社の強み', value: form.uniqueSellingPoints },
      ],
    },
    {
      title: '3. ターゲット情報',
      fields: [
        { label: 'どんな人に見てほしいか（ターゲット層）', value: form.targetAudience },
        { label: 'ターゲットが抱える悩みや求めていること', value: form.targetNeeds },
      ],
    },
    {
      title: '4. デザイン要件',
      fields: [
        { label: 'デザインのイメージ', value: designStyleLabels[form.designStyle] || '' },
        { label: '使いたい色・ブランドカラー', value: form.colorScheme },
        { label: '参考にしたいサイトURL', value: form.moodBoard },
        { label: '競合他社のサイトURL', value: form.competitorSites },
      ],
    },
    {
      title: '5. コンテンツ要件',
      fields: [
        { label: '必要なページ', value: allSitePages.join('、') },
        { label: '必要な機能', value: allFeatures.join('、') },
        { label: '訪問者に最終的にしてほしい行動', value: form.callToAction },
      ],
    },
    {
      title: '6. 予算',
      fields: [
        { label: 'おおよその予算感', value: budgetLabels[form.budget] || '' },
      ],
    },
    {
      title: '7. コンテンツ・運用',
      fields: [
        { label: 'テキスト・写真の準備状況', value: contentPreparationLabels[form.contentPreparation] || '' },
        { label: '公開後の更新方法', value: updateMethodLabels[form.updateMethod] || '' },
        { label: '更新頻度', value: updateFrequencyLabels[form.updateFrequency] || '' },
      ],
    },
    {
      title: '8. 技術要件',
      fields: [
        { label: '対応するデバイス', value: form.screenSize.join('、') },
        { label: 'その他、必要な機能・システム', value: form.specialFeatures },
      ],
    },
    {
      title: '9. その他ご要望・気になること',
      fields: [{ label: '自由記入', value: form.additionalInfo }],
    },
  ]

  return sections
    .map((section) => ({
      ...section,
      fields: section.fields.filter((f) => f.value),
    }))
    .filter((section) => section.fields.length > 0)
})

async function displayOutput() {
  showOutput.value = true
  await nextTick()
  outputSectionRef.value?.scrollIntoView({ behavior: 'smooth' })
}

function buildTextOutput() {
  let textOutput = ''
  for (const section of outputSections.value) {
    textOutput += section.title + '\n'
    for (const field of section.fields) {
      textOutput += field.label + ': ' + field.value + '\n'
    }
    textOutput += '\n'
  }
  return textOutput
}

async function sendEmail() {
  if (outputSections.value.length === 0) {
    alert('送信する内容がありません。フォームを入力してから「入力内容を表示」を押してください。')
    return
  }

  const token = turnstileToken.value || ((window as any).turnstile?.getResponse() ?? '')
  if (!token) {
    alert('セキュリティ認証を完了してください。')
    return
  }

  isSending.value = true
  try {
    const res = await fetch('/hearing-mail.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ content: buildTextOutput(), turnstileToken: token }),
    })
    const result = await res.json()
    alert(result.message)
    if (result.success) {
      ;(window as any).turnstile?.reset()
      turnstileToken.value = ''
    }
  } catch {
    alert('通信エラーが発生しました。しばらく時間をおいて再度お試しください。')
    ;(window as any).turnstile?.reset()
    turnstileToken.value = ''
  } finally {
    isSending.value = false
  }
}

async function copyOutput() {
  try {
    await navigator.clipboard.writeText(buildTextOutput())
    alert('入力内容をクリップボードにコピーしました！')
  } catch {
    alert('コピーに失敗しました。')
  }
}
</script>

<style lang="scss" scoped>
.wrap {
  font-family: "Helvetica Neue", Arial, sans-serif;
  line-height: 1.6;
  color: #333;
  background-color: #f9fbfd;
  margin: 0;
  padding: 0;
}

.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.page-title {
  color: #4a6fa5;
  text-align: center;
  margin-bottom: 30px;
  border-bottom: 2px solid #e8f0ff;
  padding-bottom: 10px;
}

.form-section {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  padding: 25px;
  margin-bottom: 25px;
}

.form-section h2 {
  color: #6384b3;
  font-size: 1.3em;
  margin-top: 0;
  margin-bottom: 15px;
  padding-bottom: 10px;
  border-bottom: 1px solid #e8f0ff;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
}

input[type="text"],
input[type="number"],
textarea,
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
  box-sizing: border-box;
}

textarea {
  min-height: 100px;
  resize: vertical;
}

.checkbox-group,
.radio-group {
  margin-top: 8px;
}

.checkbox-label,
.radio-label {
  display: block;
  margin-bottom: 5px;
  font-weight: normal;
}

.checkbox-label input,
.radio-label input {
  margin-right: 8px;
}

.btn-container {
  text-align: center;
  margin-top: 30px;
}

.btn {
  background-color: #4a6fa5;
  color: white;
  border: none;
  padding: 12px 24px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;

  &:hover:not(:disabled) {
    background-color: #6384b3;
  }

  &:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
}

.output-container {
  background-color: #f5f7fa;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  margin-top: 30px;
}

.output-container h3 {
  margin-top: 0;
  color: #4a6fa5;
}

#outputContent {
  white-space: pre-wrap;
  background-color: white;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 15px;
  min-height: 150px;
}

.output-item {
  margin-bottom: 15px;
}

.output-item h4 {
  margin-bottom: 5px;
  color: #6384b3;
}

.output-item p {
  margin-top: 5px;
  margin-bottom: 10px;
}

.helper-text {
  font-size: 0.85em;
  color: #666;
  margin-top: 5px;
}

.turnstile-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 15px 0;
}

.turnstile-verified {
  margin-top: 8px;
  font-size: 0.875em;
  color: #28a745;
  font-weight: bold;
}
</style>
