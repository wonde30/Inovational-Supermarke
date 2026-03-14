<template>
  <div class="chart-container">
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { Chart, registerables } from 'chart.js'

// Register Chart.js components
Chart.register(...registerables)

const props = defineProps({
  chartType: {
    type: String,
    required: true,
    validator: (value) => ['bar', 'pie'].includes(value)
  },
  data: {
    type: Object,
    required: true
  },
  options: {
    type: Object,
    default: () => ({})
  },
  xAxisLabel: {
    type: String,
    default: 'X Axis'
  },
  yAxisLabel: {
    type: String,
    default: 'Y Axis'
  },
  colors: {
    type: Array,
    default: () => []
  }
})

const chartCanvas = ref(null)
let chartInstance = null

const defaultColors = [
  'rgba(59, 130, 246, 0.8)',      // blue
  'rgba(234, 179, 8, 0.8)',       // yellow  
  'rgba(34, 197, 94, 0.8)'        // green
]

const defaultBorderColors = [
  'rgba(59, 130, 246, 1)',
  'rgba(234, 179, 8, 1)',
  'rgba(34, 197, 94, 1)'
]

const getChartConfig = () => {
  const baseConfig = {
    type: props.chartType,
    data: props.data,
    options: {
      responsive: true,
      maintainAspectRatio: true,
      ...props.options
    }
  }

  // Configure specific options for bar charts
  if (props.chartType === 'bar') {
    baseConfig.options = {
      ...baseConfig.options,
      scales: {
        x: {
          title: {
            display: true,
            text: props.xAxisLabel
          }
        },
        y: {
          title: {
            display: true,
            text: props.yAxisLabel
          },
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: (context) => {
              return `${context.dataset.label}: ${context.parsed.y}`
            }
          }
        },
        legend: {
          display: false
        }
      }
    }

    // Apply default colors if not provided
    if (baseConfig.data.datasets && baseConfig.data.datasets[0]) {
      if (!baseConfig.data.datasets[0].backgroundColor) {
        const colors = props.colors.length > 0 ? props.colors : defaultColors
        baseConfig.data.datasets[0].backgroundColor = baseConfig.data.labels.map(
          (label, index) => colors[index] || 'rgba(156, 163, 175, 0.8)'
        )
      }
      if (!baseConfig.data.datasets[0].borderColor) {
        const borderColors = props.colors.length > 0 
          ? props.colors.map(color => color.replace('0.8)', '1)'))
          : defaultBorderColors
        baseConfig.data.datasets[0].borderColor = baseConfig.data.labels.map(
          (label, index) => borderColors[index] || 'rgba(156, 163, 175, 1)'
        )
      }
      if (!baseConfig.data.datasets[0].borderWidth) {
        baseConfig.data.datasets[0].borderWidth = 1
      }
    }
  }

  // Configure specific options for pie charts
  if (props.chartType === 'pie') {
    baseConfig.options = {
      ...baseConfig.options,
      plugins: {
        tooltip: {
          callbacks: {
            label: (context) => {
              const label = context.label || ''
              const value = context.parsed || 0
              const total = context.dataset.data.reduce((acc, val) => acc + val, 0)
              const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0
              return `${label}: ${value} (${percentage}%)`
            }
          }
        },
        legend: {
          display: true,
          position: 'bottom'
        }
      }
    }

    // Apply default colors if not provided
    if (baseConfig.data.datasets && baseConfig.data.datasets[0]) {
      if (!baseConfig.data.datasets[0].backgroundColor) {
        const colors = props.colors.length > 0 ? props.colors : defaultColors
        baseConfig.data.datasets[0].backgroundColor = baseConfig.data.labels.map(
          (label, index) => colors[index] || 'rgba(156, 163, 175, 0.8)'
        )
      }
      if (!baseConfig.data.datasets[0].borderColor) {
        const borderColors = props.colors.length > 0 
          ? props.colors.map(color => color.replace('0.8)', '1)'))
          : defaultBorderColors
        baseConfig.data.datasets[0].borderColor = baseConfig.data.labels.map(
          (label, index) => borderColors[index] || 'rgba(156, 163, 175, 1)'
        )
      }
      if (!baseConfig.data.datasets[0].borderWidth) {
        baseConfig.data.datasets[0].borderWidth = 2
      }
    }
  }

  return baseConfig
}

const initChart = () => {
  if (!chartCanvas.value) return

  // Destroy existing chart instance
  if (chartInstance) {
    chartInstance.destroy()
  }

  // Create new chart
  const ctx = chartCanvas.value.getContext('2d')
  chartInstance = new Chart(ctx, getChartConfig())
}

// Watch for data changes and reinitialize chart
watch(() => [props.data, props.chartType, props.options], () => {
  initChart()
}, { deep: true })

onMounted(() => {
  initChart()
})

onUnmounted(() => {
  if (chartInstance) {
    chartInstance.destroy()
  }
})
</script>

<style scoped>
.chart-container {
  position: relative;
  width: 100%;
  height: 100%;
  min-height: 300px;
}
</style>
