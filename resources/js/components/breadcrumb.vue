<template>
    <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
      <ul>
        <li :class="{ 'is-active item-active-color is-success': chosenPost === 'allPosts' }">
          <a href="#" @click="choosePost('allPosts')" aria-current="page">All Posts</a>
        </li>
        <li v-if="currentUser" :class="{ 'is-active item-active-color is-success': chosenPost === 'userPosts' }">
          <a href="#" @click="choosePost('userPosts')">Your posts</a>
        </li>
      </ul>
    </nav>
  </template>

  <script>
  export default {
    props: ['chosenPost', 'currentUser'], // Include 'currentUser' prop
    emits: ['choose-post'],
    methods: {
      choosePost(postType) {
        this.$emit('choose-post', postType);
      },
    },
  };
  </script>
