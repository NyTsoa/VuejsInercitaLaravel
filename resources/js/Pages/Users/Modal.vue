<script setup>
defineProps({
  show: Boolean,
});
defineEmits(['close']);
</script>

<template>
  <div
    v-if="show"
    class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50"
  >
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
      <div class="flex justify-between items-center border-b px-4 py-2">
        <h3 class="text-lg font-semibold">
          <slot name="title" />
        </h3>
        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">&times;</button>
      </div>
      <div class="p-4">
        <slot />
      </div>
    </div>
  </div>
</template>
