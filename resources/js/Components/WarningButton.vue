<template>
    <button :type="type" class=" ml-2 mr-2 rounded-lg border border-transparent bg-yellow-400 px-4 py-2 text-center text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 hover:bg-yellow-700 focus:outline-none focus:ring active:bg-yellow-600">
      <slot/>
    </button>
  </template>
  
  <script setup>
  defineProps({
      type: {
          type: String,
          default: 'submit',
      },
  });
  </script>
  