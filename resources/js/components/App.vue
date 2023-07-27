<template>
    <div>

      <navigation /> <!-- Assuming you have a 'navigation' component -->
      <breadcrumb />
      
      
    </div>
    <allPosts />
    <newPost />
  </template>
  
  <script>
  import navigation from './navbar.vue';
  import breadcrumb from './breadcrumb.vue';
  import allPosts from './allPosts.vue';
  import newPost from './newPost.vue';
  
  export default {
    components: {
      navigation,
      breadcrumb,
      allPosts,
      newPost,
      // Add more components as needed
    },
  };
  </script>
  
  <style>
  /* Your CSS styles for the App.vue component */
  /* For example, you can style the layout here */
  </style>
  