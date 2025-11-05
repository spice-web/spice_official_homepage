import { library, config } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faExternalLinkAlt, faChevronUp } from '@fortawesome/free-solid-svg-icons'

// Font Awesomeの自動CSS追加を無効化（Nuxtで管理するため）
config.autoAddCss = false

// 使用するアイコンをライブラリに追加
library.add(faExternalLinkAlt, faChevronUp)

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.component('font-awesome-icon', FontAwesomeIcon)
})
