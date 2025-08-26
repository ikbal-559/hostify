<template>
  <button
    type="submit"
    class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold rounded-lg shadow-md hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 transition duration-200"
    :disabled="disabled"
  >
    <slot>Submit</slot>
  </button>
</template>

<script setup>
const props = defineProps({
  disabled: {
    type: Boolean,
    default: false
  }
});
</script>
