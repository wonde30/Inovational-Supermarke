<template>
  <div class="language-demo">
    <div class="demo-header">
      <h1>{{ t('common.welcome') }} - Language Demo</h1>
      <p>Current Language: <strong>{{ currentLocaleInfo.nativeName }}</strong> ({{ currentLocaleInfo.name }})</p>
    </div>

    <div class="demo-grid">
      <!-- Language Switcher Component -->
      <div class="demo-card">
        <h3>Language Switcher (Dropdown)</h3>
        <div class="component-demo">
          <LanguageSwitcher />
        </div>
        <p class="description">Click to switch between ENG, AMH, and ORM languages</p>
      </div>

      <!-- Language Selector Component -->
      <div class="demo-card">
        <h3>Language Selector (Settings)</h3>
        <div class="component-demo">
          <LanguageSelector 
            label="Choose Language"
            description="Select your preferred language for the application"
          />
        </div>
      </div>

      <!-- Translation Examples -->
      <div class="demo-card">
        <h3>Translation Examples</h3>
        <div class="translation-examples">
          <div class="example-row">
            <span class="key">common.welcome:</span>
            <span class="value">{{ t('common.welcome') }}</span>
          </div>
          <div class="example-row">
            <span class="key">auth.login:</span>
            <span class="value">{{ t('auth.login') }}</span>
          </div>
          <div class="example-row">
            <span class="key">dashboard.title:</span>
            <span class="value">{{ t('dashboard.title') }}</span>
          </div>
          <div class="example-row">
            <span class="key">pos.title:</span>
            <span class="value">{{ t('pos.title') }}</span>
          </div>
          <div class="example-row">
            <span class="key">products.title:</span>
            <span class="value">{{ t('products.title') }}</span>
          </div>
          <div class="example-row">
            <span class="key">common.save:</span>
            <span class="value">{{ t('common.save') }}</span>
          </div>
          <div class="example-row">
            <span class="key">common.cancel:</span>
            <span class="value">{{ t('common.cancel') }}</span>
          </div>
        </div>
      </div>

      <!-- Available Languages -->
      <div class="demo-card">
        <h3>Available Languages</h3>
        <div class="languages-list">
          <div 
            v-for="locale in availableLocales" 
            :key="locale.code"
            class="language-item"
            :class="{ active: locale.code === currentLocale }"
          >
            <span class="flag">{{ locale.flag }}</span>
            <div class="language-info">
              <div class="native-name">{{ locale.nativeName }}</div>
              <div class="english-name">{{ locale.name }}</div>
            </div>
            <button 
              @click="setLanguage(locale.code)"
              class="select-btn"
              :disabled="locale.code === currentLocale"
            >
              {{ locale.code === currentLocale ? 'Current' : 'Select' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useI18nStore } from '@/stores/i18n'
import LanguageSwitcher from '@/components/LanguageSwitcher.vue'
import LanguageSelector from '@/components/LanguageSelector.vue'

const i18nStore = useI18nStore()

const currentLocale = computed(() => i18nStore.currentLocale)
const currentLocaleInfo = computed(() => i18nStore.currentLocaleInfo)
const availableLocales = computed(() => i18nStore.locales)
const t = computed(() => i18nStore.t)

const setLanguage = async (localeCode) => {
  await i18nStore.setLocale(localeCode)
}
</script>

<style scoped>
.language-demo {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.demo-header {
  text-align: center;
  margin-bottom: 3rem;
}

.demo-header h1 {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 1rem;
}

.demo-header p {
  font-size: 1.125rem;
  color: var(--text-secondary);
}

.demo-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

.demo-card {
  background: var(--bg-elevated);
  border: 1px solid var(--border-primary);
  border-radius: 1rem;
  padding: 1.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.demo-card h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 1rem;
}

.component-demo {
  display: flex;
  justify-content: center;
  padding: 1rem;
  background: var(--bg-secondary);
  border-radius: 0.5rem;
  margin-bottom: 1rem;
}

.description {
  font-size: 0.875rem;
  color: var(--text-secondary);
  text-align: center;
  margin: 0;
}

.translation-examples {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.example-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem;
  background: var(--bg-secondary);
  border-radius: 0.5rem;
}

.key {
  font-family: monospace;
  font-size: 0.875rem;
  color: var(--text-secondary);
}

.value {
  font-weight: 500;
  color: var(--text-primary);
}

.languages-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.language-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: var(--bg-secondary);
  border-radius: 0.75rem;
  transition: all 0.2s ease;
}

.language-item.active {
  background: var(--bg-brand-subtle);
  border: 1px solid var(--border-brand);
}

.flag {
  font-size: 1rem;
  font-weight: 600;
  color: var(--text-primary);
  min-width: 2.5rem;
  text-align: center;
}

.language-info {
  flex: 1;
}

.native-name {
  font-weight: 500;
  color: var(--text-primary);
  font-size: 1rem;
}

.english-name {
  font-size: 0.875rem;
  color: var(--text-secondary);
}

.select-btn {
  padding: 0.5rem 1rem;
  border: 1px solid var(--border-primary);
  border-radius: 0.5rem;
  background: var(--bg-primary);
  color: var(--text-primary);
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.select-btn:hover:not(:disabled) {
  background: var(--bg-tertiary);
  border-color: var(--border-secondary);
}

.select-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>