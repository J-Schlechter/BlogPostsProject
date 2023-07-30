<template>
  <div>
    <div v-for="post in posts" :key="post.id">
      <!-- Render the post content here -->
      <h1>{{ post.title }}</h1>
      <p>{{ post.body }}</p>
      <p><b>by {{ post.user.name }}</b></p>
      <!-- Add other post details here as needed -->
    </div>
  </div>
</template>

<script>
export default {
  props: {
    posts: {
      type: Array,
      default: () => [],
    },
    currentUser: {
      type: String,
      default: null,
    },
  },
  methods: {
    getUserName(userId) {
      const user = undefined;
      const userName = user?.find((u) => u.id === 1)?.name ?? 'Default User';
      console.log(userName);
    },
  },
};
</script>
