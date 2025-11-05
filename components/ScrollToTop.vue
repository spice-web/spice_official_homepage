<template>
  <transition name="fade">
    <button
      v-if="isVisible"
      class="scroll-to-top"
      @click="scrollToTop"
      aria-label="ページトップへ戻る"
    >
      <font-awesome-icon :icon="['fas', 'chevron-up']" class="arrow-up" />
      <span class="label">TOP</span>
    </button>
  </transition>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

const isVisible = ref(false)

const handleScroll = () => {
  // 300px以上スクロールしたらボタンを表示
  isVisible.value = window.scrollY > 300
}

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped lang="scss">
.scroll-to-top {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  width: 30px;
  height: 30px;
  background-color: #ea7329;
  color: white;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  // box-shadow: 0 4px 12px rgba(234, 115, 41, 0.4);
  transition: all 0.3s ease;
  z-index: 1000;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 0;
}

.scroll-to-top:hover {
  background-color: #d66325;
  transform: translateY(-4px);
  // box-shadow: 0 6px 16px rgba(234, 115, 41, 0.5);
}

.scroll-to-top:active {
  transform: translateY(-2px);
}

.arrow-up {
  position: absolute;
  top: 3px;
  left: 50%;
  transform: translateX(-50%);
  font-size: .75rem;
  line-height: 1;
}

.label {
  font-size: 0.625rem;
  line-height: 1;
  font-weight: bold;
  letter-spacing: 0.5px;
  position: relative;
  padding-top: 0.5rem;
}

/* フェードアニメーション */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.fade-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

/* モバイル対応 */
@media (max-width: 767px) {
  .scroll-to-top {
    bottom: 1.5rem;
    right: 1.5rem;
    width: 50px;
    height: 50px;
  }

  .arrow-up {
    font-size: 1.25rem;
  }

  .label {
    font-size: 0.5625rem;
  }
}
</style>
