<template>
  <div class="language-settings">
    <div class="settings-header">
      <h3 class="settings-title">{{ t('settings.language') }}</h3>
      <p class="settings-description">{{ t('settings.languageDescription') }}</p>
    </div>

    <div class="language-options">
      <div 
        v-for="locale in availableLocales" 
        :key="locale.code"
        class="language-option"
        :class="{ 'selected': locale.code === currentLocale }"
        @click="selectLanguage(locale.code)"
      >
        <div class="language-flag">{{ locale.flag }}</div>
        <div class="language-info">
          <div class="language-native">{{ locale.nativeName }}</div>
          <div class="language-english">{{ locale.name }}</div>
        </div>
        <div class="language-status">
          <div v-if="locale.code === currentLocale" class="status-indicator active">
            <span class="checkmark">✓</span>
            <span class="status-text">{{ t('common.active') }}</span>
          </div>
          <button 
            v-else 
            class="select-button"
            @click.stop="selectLanguage(locale.code)"
            :disabled="loading"
          >
            {{ t('common.select') }}
          </button>
        </div>
      </div>
    </div>

    <div class="settings-footer">
      <div class="info-box">
        <div class="info-icon">ℹ️</div>
        <div class="info-content">
          <p class="info-title">{{ t('settings.languageInfo') }}</p>
          <p class="info-text">{{ t('settings.languageInfoDescription') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useTranslation } from '@/composables/useTranslation'

const { t, currentLocaleInfo, availableLocales, locale: currentLocale, setLocale } = useTranslation()
const loading = ref(false)

const selectLanguage = async (localeCode) => {
  if (localeCode === currentLocale.value || loading.value) return
  
  loading.value = true
  try {
    await setLocale(localeCode)
  } catch (error) {
    console.error('Failed to change language:', error)
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.language-settings {
  max-width: 600px;
}

.settings-header {
  margin-bottom: 2rem;
}

.settings-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 0.5rem;
}

.settings-description {
  color: var(--text-secondary);
  font-size: 0.875rem;
  margin: 0;
}

.language-options {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 2rem;
}

.language-option {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1.5rem;
  border: 2px solid var(--border-primary);
  border-radius: 1rem;
  background: var(--bg-elevated);
  cursor: pointer;
  transition: all 0.2s ease;
}

.language-option:hover {
  border-color: var(--border-secondary);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.language-option.selected {
  border-color: var(--border-brand);
  background: var(--bg-brand-subtle);
}

.language-flag {
  font-size: 1.5rem;
  font-weight: 600;
  min-width: 3rem;
  text-align: center;
  padding: 0.75rem;
  background: var(--bg-secondary);
  border-radius: 0.75rem;
}

.language-info {
  flex: 1;
}

.language-native {
  font-size: 1.125rem;
  font-weight: 500;
  color: var(--text-primary);
  margin-bottom: 0.25rem;
}

.language-english {
  font-size: 0.875rem;
  color: var(--text-secondary);
}

.language-status {
  display: flex;
  align-items: center;
}

.status-indicator.active {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--text-brand);
  font-weight: 500;
}

.checkmark {
  font-size: 1.25rem;
}

.select-button {
  padding: 0.5rem 1rem;
  border: 1px solid var(--border-primary);
  border-radius: 0.5rem;
  background: var(--bg-primary);
  color: var(--text-primary);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.select-button:hover:not(:disabled) {
  background: var(--bg-brand);
  color: white;
  border-color: var(--border-brand);
}

.select-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.settings-footer {
  margin-top: 2rem;
}

.info-box {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  background: var(--bg-info-subtle);
  border: 1px solid var(--border-info);
  border-radius: 0.75rem;
}

.info-icon {
  font-size: 1.25rem;
  flex-shrink: 0;
}

.info-content {
  flex: 1;
}

.info-title {
  font-weight: 500;
  color: var(--text-primary);
  margin: 0 0 0.25rem 0;
  font-size: 0.875rem;
}

.info-text {
  color: var(--text-secondary);
  font-size: 0.75rem;
  margin: 0;
  line-height: 1.4;
}
</style>