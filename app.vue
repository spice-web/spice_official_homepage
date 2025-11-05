<template>
  <div>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
      <iframe :src="`https://www.googletagmanager.com/ns.html?id=${config.public.gtmId}`" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()

// Cloudflare Turnstile
useHead({
  script: [
    {
      src: 'https://challenges.cloudflare.com/turnstile/v0/api.js',
      async: true,
      defer: true
    }
  ]
})
</script>
