<template>
  <header class="header">
    <div class="container">
      <div class="header-inner">
        <div class="header-logo">
          <NuxtLink to="/" class="logo" aria-label="ホームページへ">
            <img src="~/assets/images/logo.svg" alt="Spice" class="logo-image" />
          </NuxtLink>
          <h1>企業の味に旨みをプラス<br>株式会社スパイス</h1>
        </div>

        <button
          class="menu-toggle"
          :aria-expanded="isMenuOpen"
          aria-label="メニュー"
          @click="toggleMenu"
        >
          <span class="menu-icon" :class="{ 'is-open': isMenuOpen }"></span>
        </button>

        <nav class="nav" :class="{ 'is-open': isMenuOpen }">
          <ul class="nav-list">
            <li v-for="item in navItems" :key="item.path" class="nav-item">
              <NuxtLink :to="item.path" class="nav-link" @click="closeMenu">
                {{ item.label }}
              </NuxtLink>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
const isMenuOpen = ref(false)

const navItems = [
  { path: '/', label: 'トップ' },
  { path: '/business', label: '事業内容' },
  { path: '/products', label: '商品開発&販売' },
  { path: '/news', label: '新着情報' },
  { path: '/about', label: '会社概要' },
  { path: '/contact', label: 'お問い合わせ' }
]

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const closeMenu = () => {
  isMenuOpen.value = false
}

// モバイルメニューが開いている時、スクロールを防止
watch(isMenuOpen, (newValue) => {
  if (process.client) {
    if (newValue) {
      document.body.style.overflow = 'hidden'
    } else {
      document.body.style.overflow = ''
    }
  }
})
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;
@use '~/assets/css/mixins' as *;

.header {
  background-color: $color-background;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 100;

  .container {
    padding: 0 0.5rem;
  }
}

.header-inner {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 0;
}

.header-logo {
  display: flex;
  align-items: center;
  gap: .5rem;
  h1 {
    font-size: .75rem;
    // font-weight: normal;
    color: $color-text;
  }
}

.logo {
  width: 80px;
  @include hover-opacity;
}

.logo-image {
  height: 40px;
  width: auto;
}

// ハンバーガーメニュー
.menu-toggle {
  display: block;
  width: 40px;
  height: 40px;
  position: relative;
  z-index: 101;
}

.menu-icon {
  display: block;
  width: 24px;
  height: 2px;
  background-color: $color-primary;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  @include transition(background-color);

  &::before,
  &::after {
    content: '';
    display: block;
    width: 24px;
    height: 2px;
    background-color: $color-primary;
    position: absolute;
    left: 0;
    @include transition(transform);
  }

  &::before {
    top: -8px;
  }

  &::after {
    top: 8px;
  }

  &.is-open {
    background-color: transparent;
    
    &::before {
      background-color: white;
      transform: rotate(45deg) translate(6px, 6px);
    }

    &::after {
      background-color: white;
      transform: rotate(-45deg) translate(5px, -5px);
    }
  }
}

// ナビゲーション
.nav {
  position: fixed;
  top: 0;
  right: 0;
  width: 100%;
  height: 100vh;
  background-color: $color-background;
  transform: translateX(100%);
  background: #333;
  // opacity: 0.95;
  @include transition(transform);
  padding-top: 80px;

  &.is-open {
    transform: translateX(0);
  }
}

.nav-list {
  list-style: none;
  padding: 0 2rem;
  text-align: center;
}

.nav-item {
  margin-bottom: 1.5rem;
  font-size: .75rem;
}

.nav-link {
  display: block;
  font-size: 1.125rem;
  padding: 0.5rem;
  color: $color-text;
  @include hover-opacity;
  position: relative;

  .is-open & {
    color: white;
  }

  &::after {
    content: '';
    display: block;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    text-align: center;
  }
}

.nav-item:nth-child(1) .nav-link::after {
  content: 'TOP';
  color: #fa781e;
}

.nav-item:nth-child(2) .nav-link::after {
  content: 'Service';
  color: #c80a1e;
}

.nav-item:nth-child(3) .nav-link::after {
  content: 'Products';
  color: #289696;
}

.nav-item:nth-child(4) .nav-link::after {
  content: 'News';
  color: #007cc3;
}

.nav-item:nth-child(5) .nav-link::after {
  content: 'Company';
  color: #8c50d2;
}

.nav-item:nth-child(6) .nav-link::after {
  content: 'Contact';
  color: #666666;
}

// タブレット以上
@include responsive($breakpoint-md) {
  .header-logo {
    flex-direction: column;
    gap: .25rem;
    h1 {
      // font-size: .875rem;
      text-align: center;
    }
  }

  .menu-toggle {
    display: none;
  }

  .nav {
    position: static;
    width: auto;
    height: auto;
    background-color: transparent;
    transform: none;
    padding-top: 0;
  }

  .nav-list {
    display: flex;
    padding: 0;
  }

  .nav-item {
    padding: 0 1rem;
    border-left: 1px solid var(--color-primary);
    margin-bottom: 0;
    font-weight: bold;
  }

  .nav-link {
    font-size: .875rem;
    padding: 0;
    &::after {
      margin: 0;
    }
  }
}

// タブレット未満
@include responsive-down($breakpoint-md) {
  .header-logo {
    h1 {
      br {
        display: none;
      }
    }
  }
}

@include responsive($breakpoint-lg) {
  .header-logo {
    flex-direction: row;
    gap: 1rem;
    h1 {
      // font-size: 1rem;
      text-align: left;
      br {
        display: none;
      }
    }
  }
}
</style>
