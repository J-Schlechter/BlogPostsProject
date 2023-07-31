<template>
    <div class="modal is-active">
      <div class="modal-background" @click="$emit('close')"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Comments for {{ post.title }}</p>
          <button class="delete" aria-label="close" @click="$emit('close')"></button>
        </header>
        <section class="modal-card-body">
          <!-- Display comments -->
          <div v-if="comments.length > 0">
            <div v-for="comment in sortedComments" :key="comment.id">
              <p>{{ comment.text }}</p>
              <hr />
            </div>
          </div>
          <div v-else>
            <p>No comments yet.</p>
          </div>
  
          <!-- Add new comment -->
          <div>
            <input v-model="newComment" type="text" placeholder="Add a new comment" />
            <button @click="addNewComment">Add Comment</button>
          </div>
        </section>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, computed } from 'vue';
  
  export default {
  props: {
    post: {
      type: Object,
      required: true, // Make sure the post prop is required
    },
    comments: {
      type: Array,
      default: () => [],
      },
    },
    setup(props, { emit }) {
      const newComment = ref('');
  
      // Compute sorted comments based on the createdAt timestamp (latest first)
      const sortedComments = computed(() => {
        return props.comments.slice((a, b) => new Date(b.created_at) - new Date(a.created_at));
      });
  
      const addNewComment = () => {
        // Emit the new comment text to the parent component
        emit('add-comment', newComment.value);
        newComment.value = ''; // Clear the input field after adding the comment
      };
  
      return {
        newComment,
        sortedComments,
        addNewComment,
      };
    },
  };
  </script>
  
  <style>
  /* Add your modal styles here if needed */
  </style>
  