<!-- resources/js/components/Toast.vue -->
<template>
    <div class="toast is-success">{{ message }}</div>
  </template>
  
  <script>
  export default {
    props: {
      message: String,
    },
  };
  </script>
  
  <style>
  /* Add your CSS styles for the Toast.vue component */
  </style>
  