<template>
  <button
    :type="type"
    :class="[
      'ml-4 px-4 py-2 inline-flex items-center bg-gradient-to-r bg-gray-600 text-white font-semibold rounded-lg shadow-md',
      'hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 transition duration-200',
      customClass
    ]"
    v-bind="$attrs"
    @click="$emit('click', $event)"
  >
    <slot />
  </button>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
const props = defineProps({
  type: {
    type: String,
    default: 'button',
  },
  customClass: {
    type: String,
    default: '',
  },
});
defineEmits(['click']);
</script>
