/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // Enable dark mode with class strategy
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        // Brand colors
        brand: {
          primary: '#16A34A',    // Fresh Retail Green
          secondary: '#2563EB',  // Smart Technology Blue
          accent: '#F97316',     // Promotions Orange
        },
        // Semantic color scales
        fresh: {
          50: '#F0FDF4',
          100: '#DCFCE7',
          200: '#BBF7D0',
          300: '#86EFAC',
          400: '#4ADE80',
          500: '#22C55E',        // Success/Fresh Items
          600: '#16A34A',        // Primary Brand
          700: '#15803D',        // Active Element
          800: '#166534',
          900: '#14532D',
        },
        smart: {
          50: '#EFF6FF',
          100: '#DBEAFE',
          200: '#BFDBFE',
          300: '#93C5FD',
          400: '#60A5FA',
          500: '#2563EB',        // Secondary Color
          600: '#1D4ED8',
          700: '#1E40AF',
          800: '#1E3A8A',
          900: '#1E3A8A',
        },
        promo: {
          50: '#FFF7ED',
          100: '#FFEDD5',
          200: '#FED7AA',
          300: '#FDBA74',
          400: '#FB923C',
          500: '#F97316',        // Accent Color
          600: '#EA580C',
          700: '#C2410C',
          800: '#9A3412',
          900: '#7C2D12',
        },
        alert: {
          50: '#FFFBEB',
          100: '#FEF3C7',
          200: '#FDE68A',
          300: '#FCD34D',
          400: '#FBBF24',
          500: '#F59E0B',        // Warning Color
          600: '#D97706',
          700: '#B45309',
          800: '#92400E',
          900: '#78350F',
        },
        // Background colors
        background: {
          main: '#F8FAFC',
          card: '#FFFFFF',
          section: '#F1F5F9',
          hover: '#E8F5E9',
        },
        // Text colors
        text: {
          primary: '#0F172A',
          secondary: '#475569',
          disabled: '#94A3B8',
        },
        // Border color
        border: {
          DEFAULT: '#E2E8F0',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
      },
    },
  },
  plugins: [],
}
