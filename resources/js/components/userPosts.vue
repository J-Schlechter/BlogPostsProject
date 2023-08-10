<template>
    <div>
      <div v-for="post in postsData" :key="post.id">
        <div class="container is-max-desktop pb-3 rounded-block">
          <div class="notification is-primary rounded-block">
            <div class="columns">
              <div class="column is-half ">
                <b class="title">{{ post.title }}</b>
                <br>
                <h2 class="subtitle">{{ post.body }}</h2>

                <div class="button-container">
                  <template v-if="currentUser === post.user.name">
                    <button class="button is-warning" @click="viewEditPostModal(post)">Edit Post</button>
                    <button class="button is-danger" @click="deletePost(post)">Delete Post</button>
                  </template>
                  <button class="button has-background-warning-dark" @click="viewComments(post)">View Comments</button>
                </div>
              </div>
              <div class="column is-half is-flex is-justify-content-center">
                <div v-if="post.image_path === null"></div>
                <div v-else>
                  <img :src="'/storage/images/' + post.image_path" alt="Post Image" style="max-width: 100%; max-height: 200px; margin-top: 10px;" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Edit-Post-Modal v-if="showEditPostModal" :post="editingPost" @save-post="savePost" @close="closeEditPostModal" />
      <CommentModal
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
  import { ref, onMounted, onUnmounted, watch } from 'vue';
  import axios from 'axios';
  import Swal from 'sweetalert2';
  import EditPostModal from './EditPostModal.vue';

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


    setup(props, { emit }) {
      const postsData = ref(props.posts);
      const showEditPostModal = ref(false);
      const editingPost = ref(null);
      const selectedPost = ref(null);
      const postCount = ref(null);
      console.log(props.currentUser)
      const reloadPosts = () => {
        axios
          .get('/userPosts')
          .then((response) => {
            console.log(response.data)
            postsData.value = response.data;
          })
          .catch((error) => {
            console.error('Error fetching posts data:', error);
          });
      };

      const deletePost = (post) => {
        Swal.fire({
          title: 'Are you sure you want to delete this post?',
          showDenyButton: true,
          confirmButtonText: 'Delete',
          denyButtonText: 'Cancel',
        }).then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`/delete-post/${post.id}`)
              .then((response) => {
                console.log('Post deleted:', response.data);
                postsData.value = postsData.value.filter((p) => p.id !== post.id);
                Swal.fire({
                  icon: 'success',
                  title: 'Post Successfully Deleted',
                  timer: 1000,
                  timerProgressBar: true,
                  didOpen: () => {
                    Swal.showLoading();
                  },
                  willClose: () => {

                  },
                });
              })
              .catch((error) => {
                console.error('Error deleting post:', error);
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'An error occurred while deleting the post.',
                });
              });
          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info');
          }
        });
      };

      const viewEditPostModal = (post) => {
        axios
          .get(`/showEditScreen/${post.id}`)
          .then((response) => {
            console.log(response.data);
            editingPost.value = { ...post, postind: response.data };
            showEditPostModal.value = true;
          })
          .catch((error) => {
            console.error('Error fetching comments:', error);
          });
      };

      const closeEditPostModal = () => {
        editingPost.value = null;
        showEditPostModal.value = false;
      };

      const viewComments = (post) => {
        axios
          .get(`/viewComments/${post.id}`)
          .then((response) => {
            selectedPost.value = { ...post, comments: response.data };
          })
          .catch((error) => {
            console.error('Error fetching post:', error);
          });
      };

      const savePost = (newPostData) => {
        axios
          .put(`/edit-post/${newPostData.id}`, { title: newPostData.title, body: newPostData.body })
          .then((response) => {
            selectedPost.value = null;
            emit('post-saved');
            Swal.fire({
              icon: 'success',
              title: 'Post Successfully Edited',
              timer: 1000,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
              },
              willClose: () => {

              },
            });
            reloadPosts();
          })
          .catch((error) => {
            console.error('Error fetching post:', error);
          });
      };

      const addComment = (newCommentText) => {
        console.log(newCommentText);
        console.log(selectedPost.value.id);
        if (selectedPost.value) {
          const post_id = selectedPost.value.id;
          axios
            .post(`/addComment/${post_id}`, { text: newCommentText })
            .then((response) => {
              selectedPost.value = null;
              Swal.fire({
                icon: 'success',
                title: 'Commented Successfully',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading();
                },
                willClose: () => {

                },
              });
            })
            .catch((error) => {
              if (error.message === 'Request failed with status code 422') {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'You have to enter something in the text field',
                });
              } else if (error.message === 'Request failed with status code 500') {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'You have to be logged in to comment',
                });
              }
              console.error('Error:', error.message);
            });
        }
      };

      return {
        postsData,
        showEditPostModal,
        editingPost,
        selectedPost,
        reloadPosts,
        deletePost,
        viewEditPostModal,
        closeEditPostModal,
        viewComments,
        savePost,
        addComment,
      };
    },

    components: {
      CommentModal,
      EditPostModal,
    },

    created() {
      this.reloadPosts();
    },
  };
  </script>

  <style>
  /* Add custom styling for the post list */
  .container {
    margin-top: 20px; /* Add margin to separate each post container */
    border: 1px solid black; /* Add a border around the post container */
    background-color: gray; /* Set the background color */
    padding: 20px; /* Add padding inside the container */
  }

  .columns {
    margin: 0; /* Remove default margin for columns */
  }

  .title {
    margin-bottom: 10px;
    text-align: left; /* Center the post title */
  }

  .subtitle {
    margin-top: 10px;
    text-align: left; /* Center the post body */
  }

  h5 {
    text-align: left; /* Center the post author name */
  }

  .button-container {
    text-align: right; /* Center the buttons */
    margin-top: 10px; /* Add margin between the buttons and post content */
  }

  /* Optional: Add some spacing between posts */
  .container:not(:first-child) {
    margin-top: 30px;
  }
  .rounded-block {
    border-radius: 10px;
  }
  </style>
