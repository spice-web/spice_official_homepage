<template>
  <nav class="breadcrumb" aria-label="パンくずリスト">
    <ol class="breadcrumb-list">
      <li class="breadcrumb-item">
        <NuxtLink to="/" class="breadcrumb-link">ホーム</NuxtLink>
      </li>
      <li v-for="(item, index) in items" :key="index" class="breadcrumb-item">
        <span class="breadcrumb-separator">/</span>
        <NuxtLink v-if="item.path" :to="item.path" class="breadcrumb-link">
          {{ item.label }}
        </NuxtLink>
        <span v-else class="breadcrumb-current" aria-current="page">
          {{ item.label }}
        </span>
      </li>
    </ol>
  </nav>
</template>

<script setup lang="ts">
interface BreadcrumbItem {
  label: string
  path?: string
}

interface Props {
  items: BreadcrumbItem[]
}

defineProps<Props>()
</script>

<style scoped lang="scss">
@use '~/assets/css/variables' as *;

.breadcrumb {
  padding: 1rem 0;
  // background-color: #f8f9fa;
}

.breadcrumb-list {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  list-style: none;
  padding: 0 1rem;
  gap: 0.5rem;
  max-width: 1200px;
  margin: 0 auto;
}

.breadcrumb-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
}

.breadcrumb-separator {
  color: $color-secondary;
}

.breadcrumb-link {
  color: $color-text;
  text-decoration: none;
  transition: color 0.3s ease;

  &:hover {
    color: $color-accent;
    text-decoration: underline;
  }
}

.breadcrumb-current {
  color: $color-secondary;
  font-weight: 500;
}

@media (min-width: 768px) {
  .breadcrumb-list {
    padding: 0 2rem;
  }

  .breadcrumb-item {
    font-size: 1rem;
  }
}
</style>
