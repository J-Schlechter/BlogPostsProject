<template>
  <div>
    <div v-for="post in posts" :key="post.id">
      <div class="container is-max-desktop pb-3">
      <div class="notification is-primary">
        <div style="background-color: gray; padding: 20px; margin:20px; border: 1px solid black;">
          <!-- Render the post content here -->
          <h1 class='title'>{{ post.title }}</h1><b> by {{ post.user.name }}</b>
          <h2 class='subtitle'>{{ post.body }}</h2>
          <h2>{{currentUser}}</h2>
      <!-- Add other post details here as needed -->
      <template v-if="currentUser === post.user.name">
        <form action="edit-post/{{$post->id}}" method="GET">
        
        <button class="button is-warning">Edit Post</button>
      </form>
      <br>
      <button class="js-modal-trigger button is-danger" data-target="modal-js-delete">
        Delete Post
      </button>
      </template>
      <button class="button is-primary" @click="viewComments(post)">View Comments</button>
        </div>
      </div>
    </div>
  </div>
  <comment-modal
      v-if="selectedPost"
      :post="selectedPost"
      :comments="selectedPost.comments"
      @add-comment="addComment"
      @close="selectedPost = null"
    />
</div>
</template>

<script>
import CommentModal from './CommentModal.vue';
import { ref } from 'vue';
import axios from 'axios';

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
    deletePost(post) {
      // Implement the deletePost method as you did before
    },
  },
  setup(props) {
    // Define a ref to keep track of the selected post for the comment modal
    const selectedPost = ref(null);

    // Function to view comments for a specific post
    const viewComments = (post) => {
      
      axios
        .get(`/viewComments/${post.id}`) // Use the new route for viewing comments
        .then((response) => {
         
          selectedPost.value = { ...post, comments: response.data };
        })
        .catch((error) => {
          console.error('Error fetching comments:', error);
        });
    };

    // Function to add a new comment to the selected post
    const addComment = (newCommentText) => {
      console.log(newCommentText)
      console.log(selectedPost.value.id)
      if (selectedPost.value) {
        const post_id = selectedPost.value.id;
        axios
          .post(`/addComment/${post_id}`,{ text: newCommentText })
          .then((response) => {
            
            // Close the comment modal after adding the comment
            selectedPost.value = null;
          })
          .catch((error) => {
            console.error('Error adding comment:', error);
          });
      }
    };

    return {
      selectedPost,
      viewComments,
      addComment,
    };
  },
  components: {
    CommentModal,
  },
};
</script>
