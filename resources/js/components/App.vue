<template>
    <div>
      <navigation /> <!-- Assuming you have a 'navigation' component -->
      <main>
        <helloworld /> <!-- Assuming you have a 'helloworld' component -->
        <!-- Your other components and content here -->
      </main>
      <footer>
        <!-- Your footer content here -->
      </footer>
    </div>
  </template>
  
  <script>
  import navbar from './components/navbar.vue';
  import helloworld from './components/helloworld.vue';
  
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
  