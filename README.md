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
- `MICROCMS_SERVICE_DOMAIN`: microCMSのサービスドメイン
- `MICROCMS_API_KEY`: microCMSのAPIキー
- `GOOGLE_ANALYTICS_ID`: Google AnalyticsのID

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
├── assets/          # CSS、画像などの静的アセット
├── components/      # Vueコンポーネント
├── composables/     # コンポーザブル関数
├── layouts/         # レイアウトコンポーネント
├── middleware/      # ミドルウェア
├── pages/           # ページコンポーネント（自動ルーティング）
├── plugins/         # プラグイン
├── public/          # 公開ファイル（favicon等）
├── server/          # サーバーサイドAPI
├── types/           # TypeScript型定義
└── utils/           # ユーティリティ関数
```

## ページ一覧

- `/` - トップページ
- `/business` - 事業内容
- `/products` - 商品開発&販売
- `/news` - 新着情報
- `/about` - 会社概要
- `/contact` - お問い合わせ
- `/privacy` - プライバシーポリシー
- `/tokushoho` - 特定商取引法に基づく表記
- `/sitemap` - サイトマップ

## 技術スタック

- **フレームワーク**: Nuxt 3
- **言語**: TypeScript
- **スタイル**: SCSS
- **CMS**: microCMS
- **フォント**: Noto Sans JP
- **アナリティクス**: Google Analytics

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

## デプロイ

さくらレンタルサーバーへのデプロイ手順は別途ドキュメントを参照してください。

## ライセンス

Private
