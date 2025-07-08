<template>
  <label class="checkbox-wrapper">
    <input
      type="checkbox"
      :checked="modelValue"
      @change="$emit('update:modelValue', $event.target.checked)"
    />
    <span class="checkbox-custom"></span>
    <span class="checkbox-label">{{ label }}</span>
  </label>
</template>

<script setup>
defineProps({
  modelValue: Boolean,
  label: {
    type: String,
    default: ``,
  },
})

defineEmits([`update:modelValue`])
</script>

<style scoped>
.checkbox-wrapper {
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  user-select: none;
}

input[type='checkbox'] {
  display: none;
}

.checkbox-custom {
  width: 16px;
  height: 16px;
  border: 2px solid #666;
  border-radius: 4px;
  margin-right: 8px;
  position: relative;
  transition: background-color 0.2s;
}

input[type='checkbox']:checked + .checkbox-custom {
  background-color: #42b983;
  border-color: #42b983;
}

input[type='checkbox']:checked + .checkbox-custom::after {
  content: '';
  position: absolute;
  top: 2px;
  left: 5px;
  width: 4px;
  height: 8px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}
</style>
