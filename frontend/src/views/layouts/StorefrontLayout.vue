<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <header class="shadow-lg" style="background: linear-gradient(135deg, var(--color-brand-primary) 0%, #15803D 100%);">
      <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <router-link to="/store" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, var(--color-brand-secondary) 0%, #1D4ED8 100%);">
            <span class="text-xl">🏪</span>
          </div>
          <div>
            <span class="text-xl font-bold text-white">Smart SuperMarket</span>
            <p class="text-xs text-yellow-300">{{ t('storefront.subtitle') }}</p>
          </div>
        </router-link>
        <nav class="flex items-center space-x-4">
          <ThemeToggle />
          <LanguageSwitcher />
          <router-link to="/store/products" class="text-white/80 hover:bg-white/10 hover:text-white font-medium transition-all px-3 py-2 rounded-lg">{{ t('navigation.products') }}</router-link>
          <router-link to="/store/cart" class="text-white/80 hover:bg-white/10 hover:text-white font-medium transition-all px-3 py-2 rounded-lg flex items-center gap-1">
            🛒 {{ t('navigation.cart') }}
            <span v-if="cartCount" class="text-white text-xs px-2 py-0.5 rounded-full animate-pulse" style="background: var(--color-brand-accent);">{{ cartCount }}</span>
          </router-link>
          <router-link to="/store/orders" class="text-white/80 hover:bg-white/10 hover:text-white font-medium transition-all px-3 py-2 rounded-lg">{{ t('navigation.orders') }}</router-link>
        </nav>
      </div>
      <!-- Smart Flag Bar -->
      <div class="flex">
        <div class="h-1 flex-1 bg-green-500"></div>
        <div class="h-1 flex-1 bg-yellow-500"></div>
        <div class="h-1 flex-1 bg-red-500"></div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 bg-gradient-to-br from-gray-50 to-gray-100">
      <router-view />
    </main>

    <!-- Footer -->
    <footer class="text-white py-6" style="background: linear-gradient(135deg, var(--color-brand-primary) 0%, #15803D 100%);">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
          <div class="flex items-center gap-3">
            <span class="text-2xl">🇪🇹</span>
            <div>
              <p class="font-bold">{{ t('footer.smartSupermarket') }}</p>
              <p class="text-xs text-yellow-300">{{ t('footer.smartSupermarket') }}, {{ t('settings.yourCity') }}</p>
            </div>
          </div>
          <div class="flex gap-2">
            <div class="h-2 w-8 bg-green-500 rounded-full"></div>
            <div class="h-2 w-8 bg-yellow-500 rounded-full"></div>
            <div class="h-2 w-8 bg-red-500 rounded-full"></div>
          </div>
          <p class="text-sm text-white/80">{{ t('footer.copyrightText', { year: new Date().getFullYear() }) }}</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useCartStore } from '../../stores/cart'
import { useTranslation } from '../../composables/useTranslation'
import ThemeToggle from '../../components/ThemeToggle.vue'
import LanguageSwitcher from '../../components/LanguageSwitcher.vue'

const cartStore = useCartStore()
const { t } = useTranslation()
const cartCount = computed(() => cartStore.itemCount)
</script>

