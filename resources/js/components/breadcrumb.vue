<!-- breadcrumb.vue -->

<template>
  <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
    <ul>
      <li :class="{ 'is-active item-active-color is-success': chosenPost === 'allPosts' }">
        <a href="#" @click="viewAllPosts" aria-current="page">All Posts</a>
      </li>
      <li :class="{ 'is-active item-active-color is-success': chosenPost === 'userPosts' }">
        <a href="#" @click="viewUserPosts">Your posts</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: ['chosenPost'],
  emits: ['all-posts', 'user-posts'],
  methods: {
    viewAllPosts() {
      this.$emit('all-posts');
    },
    viewUserPosts() {
      this.$emit('user-posts');
    }
  }
};
</script>
