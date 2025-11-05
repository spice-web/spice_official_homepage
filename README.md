# SPICE 会社ホームページ

Nuxt.jsで構築した会社ホームページです。

## セットアップ

### 必要な環境

- Node.js (LTS版推奨)
- yarn

### インストール

```bash
# 依存パッケージのインストール
yarn install
```

### 環境変数の設定

`.env.example`をコピーして`.env`ファイルを作成し、必要な環境変数を設定してください。

```bash
cp .env.example .env
```

必要な環境変数:
- `MICROCMS_SERVICE_DOMAIN`: microCMSのサービスドメイン（例: your-service.microcms.io）
- `MICROCMS_API_KEY`: microCMSのAPIキー
- `GTM_ID`: Google Tag ManagerのID（デフォルト: GTM-56C5JFV）
- `TURNSTILE_SITE_KEY`: Cloudflare Turnstileのサイトキー（お問い合わせフォーム用）

## 開発

### 開発サーバーの起動

```bash
yarn dev
```

開発サーバーが起動したら、`http://localhost:3000`でアクセスできます。

### ビルド

本番環境用のビルド:

```bash
yarn build
```

### プレビュー

ビルド後のプレビュー:

```bash
yarn preview
```

### 静的サイト生成

```bash
yarn generate
```

## プロジェクト構成

```
.
├── assets/              # CSS、画像などの静的アセット
│   ├── css/            # グローバルスタイル（SCSS）
│   └── images/         # 画像ファイル
├── components/          # Vueコンポーネント
│   └── business/       # 事業ページ用コンポーネント（FLOCSS準拠）
├── composables/         # コンポーザブル関数
│   └── useMicroCMS.ts  # microCMS API関連
├── layouts/             # レイアウトコンポーネント
├── middleware/          # ミドルウェア
├── pages/               # ページコンポーネント（自動ルーティング）
│   ├── business/       # 事業ページ
│   ├── contact/        # お問い合わせページ
│   └── news/           # ニュースページ
├── plugins/             # プラグイン
├── public/              # 公開ファイル（favicon等）
├── server/              # サーバーサイドAPI
├── types/               # TypeScript型定義
├── utils/               # ユーティリティ関数
└── error.vue            # エラーページ（404, 500など）
```

## ページ一覧

### 本番環境ページ
- `/` - トップページ（microCMS連携: ニュース一覧）
- `/business` - 事業・サービス（コンポーネント化済み）
  - ECサイト運営
  - ウェブサイト制作（microCMS連携）
  - ネットショップ作成サービス
  - LINE公式アカウント
  - DTP・印刷物デザイン
  - その他サービス
- `/products` - 商品開発&販売（microCMS連携）
- `/news` - 新着情報一覧（microCMS連携）
- `/news/[id]` - 新着情報詳細（microCMS連携）
- `/about` - 会社概要
- `/contact` - お問い合わせ（Cloudflare Turnstile対応）
- `/privacy` - プライバシーポリシー
- `/tokushoho` - 特定商取引法に基づく表記
- `/sitemap` - サイトマップ

### 開発環境専用ページ
- `/test-error` - エラーページテスト（本番ビルドには含まれません）

## 技術スタック

- **フレームワーク**: Nuxt 3
- **言語**: TypeScript
- **スタイル**: SCSS（FLOCSS命名規則）
- **CMS**: microCMS
  - ニュース・お知らせ管理
  - サイト制作実績管理
  - 商品情報管理
- **フォント**: Noto Sans JP（Google Fonts）
- **アナリティクス**: Google Tag Manager
- **セキュリティ**: Cloudflare Turnstile（お問い合わせフォーム）
- **アイコン**: Font Awesome

## SCSS の使い方

このプロジェクトでは SCSS を使用しています。

### グローバルなスタイル

- `assets/css/main.scss`: メインのスタイルファイル
- `assets/css/_variables.scss`: カラー、フォント、ブレークポイントの変数
- `assets/css/_mixins.scss`: 再利用可能な mixin 集

### コンポーネント内での使用

Vue コンポーネント内で SCSS を使用する場合:

```vue
<style scoped lang="scss">
@import '@/assets/css/variables';
@import '@/assets/css/mixins';

.my-component {
  color: $color-primary;
  @include responsive($breakpoint-md) {
    font-size: 1.5rem;
  }
}
</style>
```

### 利用可能な変数

- `$color-primary`: プライマリカラー
- `$color-secondary`: セカンダリカラー
- `$color-accent`: アクセントカラー
- `$breakpoint-sm`: 640px
- `$breakpoint-md`: 768px
- `$breakpoint-lg`: 1024px
- `$breakpoint-xl`: 1280px

### 利用可能な mixin

- `@include responsive($breakpoint)`: レスポンシブデザイン
- `@include flex-center`: Flexbox 中央配置
- `@include hover-opacity($opacity)`: ホバーエフェクト
- `@include text-ellipsis`: テキスト省略
- `@include text-clamp($lines)`: 複数行のテキスト省略

### FLOCSS命名規則

このプロジェクトではFLOCSSの命名規則を採用しています。

**基本構造:**
- **Layout (l-)**: ヘッダー、フッター、メインコンテナなど
  - 例: `.l-header`, `.l-footer`, `.l-container`
- **Component (c-)**: 再利用可能な汎用コンポーネント
  - 例: `.c-button`, `.c-card`, `.c-headline__lv2`
- **Project (p-)**: プロジェクト固有のコンポーネント
  - 例: `.p-ec-shop`, `.p-shop-card`, `.p-netshop`

**BEM記法との組み合わせ:**
- **Block**: `.p-shop-card`
- **Element**: `.p-shop-card__inner`, `.p-shop-card__image`
- **Modifier**: `.p-shop-card__btn--official`, `.p-shop-card__btn--yahoo`

## microCMS連携

このプロジェクトでは、以下のコンテンツをmicroCMSで管理しています。

### エンドポイント一覧

#### 1. information（お知らせ・ニュース）
- **API ID**: `information`
- **タイプ**: リスト形式
- **フィールド**:
  - `title`: タイトル（テキスト）
  - `content`: 本文（リッチエディタ）
  - `publishedAt`: 公開日（日時）
  - `category`: カテゴリ（コンテンツ参照）
  - `thumbnail`: サムネイル画像（画像）

#### 2. site-production（サイト制作実績）
- **API ID**: `site-production`
- **タイプ**: リスト形式
- **フィールド**:
  - `title`: クライアント名（テキスト）
  - `content`: 詳細説明（リッチエディタ）
  - `thumbnail`: サムネイル画像（画像）

#### 3. products（商品情報）
- **API ID**: `products`
- **タイプ**: リスト形式
- **フィールド**:
  - `name`: 商品名（テキスト、必須）
  - `image`: 商品画像（画像、必須）
  - `url`: 商品ページURL（テキスト、任意）
  - `description`: 商品説明（テキストエリア、必須）

### 使用方法

`composables/useMicroCMS.ts` にて各エンドポイント用の関数を定義しています。

```typescript
// ニュース一覧を取得
const { data } = await useAsyncData('information', async () => {
  return await useInformation()
})

// サイト制作実績を取得
const { data } = await useAsyncData('site-production', async () => {
  return await useSiteProduction()
})

// 商品情報を取得
const { data } = await useAsyncData('products', async () => {
  return await useProducts()
})
```

## コンポーネント構成

### business（事業ページ）コンポーネント

`components/business/` 配下に事業ページのセクションをコンポーネント化しています。

**利用可能なコンポーネント:**
- `<BusinessEcShopSection />` - ECサイト運営セクション
- `<BusinessWebsiteSection />` - ウェブサイト制作セクション（microCMS連携）
- `<BusinessNetshopSection />` - ネットショップ作成サービスセクション
- `<BusinessLineSection />` - LINE公式アカウントセクション

**使用例:**
```vue
<template>
  <div class="container">
    <BusinessEcShopSection />
    <BusinessWebsiteSection />
  </div>
</template>
```

## エラーページ

`error.vue` にカスタムエラーページを実装しています。

**対応するエラーコード:**
- **404**: ページが見つかりません
- **500**: サーバーエラー
- **403**: アクセスが拒否されました
- **その他**: 予期しないエラー

**テスト方法:**
```
# 開発環境でエラーページをテスト
http://localhost:3000/test-error

# 存在しないページで404を確認
http://localhost:3000/this-page-does-not-exist
```

**注意**: `/test-error` ページは開発環境専用で、本番ビルドには含まれません。

## デプロイ

さくらレンタルサーバーへのデプロイ手順は別途ドキュメントを参照してください。

## ライセンス

Private
