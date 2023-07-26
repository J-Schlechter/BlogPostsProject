<template>
    <div>

      <navigation /> <!-- Assuming you have a 'navigation' component -->


      <breadcrumb />
      <posts />
      
    </div>
  </template>
  
  <script>
  import navigation from './navbar.vue';
  import breadcrumb from './breadcrumb.vue';
  import posts from './posts.vue';
  
  export default {
    components: {
      navigation,
      breadcrumb,
      posts,
      // Add more components as needed
    },
  };
  </script>
  
  <style>
  /* Your CSS styles for the App.vue component */
  /* For example, you can style the layout here */
  </style>
  