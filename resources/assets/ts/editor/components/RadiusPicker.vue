<script setup lang="ts">
const options = [
  { value: 'none', label: 'None' },
  { value: 'xs', label: 'XS' },
  { value: 'sm', label: 'SM' },
  { value: 'md', label: 'MD' },
  { value: 'xl', label: 'XL' },
  { value: 'full', label: 'Full' },
];
const model = defineModel({ default: 'none' });
</script>

<template>
  <div class="radius-picker-container">
    <button
      v-for="r in options"
      :key="r.value"
      type="button"
      @click="model = r.value"
      class="radius-picker-button"
      :class="{ 'is-active': model === r.value }"
    >
      <div class="radius-preview" :class="['radius-' + r.value]"></div>
      <span class="radius-label">{{ r.label }}</span>
    </button>
  </div>
</template>

<style scoped>
.radius-picker-container {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  padding: 0.25rem;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 0.75rem;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.radius-picker-button {
  flex: 1;
  min-width: 44px;
  height: 44px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.25rem;
  border-radius: 0.5rem;
  transition: all 0.2s ease;
  border: 1px solid transparent;
  background: rgba(255, 255, 255, 0.05);
  color: #a1a1aa;
  cursor: pointer;
  outline: none;
}

.radius-picker-button:hover {
  background: rgba(255, 255, 255, 0.1);
  color: #ffffff;
}

.radius-picker-button.is-active {
  background: #2563eb;
  border-color: #3b82f6;
  color: #ffffff;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
  transform: translateY(-1px);
}

.radius-preview {
  width: 1rem;
  height: 1rem;
  border: 2px solid currentColor;
  opacity: 0.8;
}

.radius-label {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: -0.01em;
}

.radius-none {
  border-radius: 0;
}
.radius-xs {
  border-radius: 2px;
}
.radius-sm {
  border-radius: 4px;
}
.radius-md {
  border-radius: 6px;
}
.radius-xl {
  border-radius: 10px;
}
.radius-full {
  border-radius: 50%;
}
</style>
