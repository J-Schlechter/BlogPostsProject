<template>
    <div>

      <navigation /> <!-- Assuming you have a 'navigation' component -->
      <helloworld />
    </div>
  </template>
  
  <script>
  import navigation from './navbar.vue';
  import helloworld from './helloworld.vue';
  
  export default {
    components: {
      navigation,
      helloworld,
      // Add more components as needed
    },
  };
  </script>
  
  <style>
  /* Your CSS styles for the App.vue component */
  /* For example, you can style the layout here */
  </style>
  