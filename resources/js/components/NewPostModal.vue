<template>
  <div class="modal" :class="{ 'is-active': showNewPostProp }">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-content">
      <div class="box">
        <form @submit.prevent="savePost" enctype="multipart/form-data">
          <div class="field">
            <label class="label">Title</label>
            <div class="control">
              <input class="input" v-model="fields.title" type="text" id="title" name="title" placeholder="Your post's title" required>
            </div>
          </div>

          <div class="field">
            <label class="label">Post Content</label>
            <div class="control">
              <textarea class="textarea" v-model="fields.body" id="body" name="body" placeholder="Write your post here!" required></textarea>
            </div>
          </div>

          <!-- Add the image upload section -->
          <div class="field">
            <label class="label">Upload Image</label>
            <div class="file is-warning">
              <label class="file-label">
                <input class="file-input" type="file" name="image" @change="onImageChange" />
                <span class="file-cta">
                  <span class="file-icon">
                    <i class="fas fa-upload"></i>
                  </span>
                  <span class="file-label">
                    Choose an image less than 1mb...
                  </span>
                </span>
              </label>
            </div>
          </div>

          <div v-if="errorMessage" class="has-text-danger">{{ errorMessage }}</div>

          <button class="button is-success">Save</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, emit } from 'vue';
import Swal from 'sweetalert2';
import app from './App.vue'

export default {
  emits: ['close-modal', 'save-post'],
  props: {
    showNewPostProp: {
      type: Boolean,
      default: false,
    },
  },
  setup(props, { emit }) {
    const fields = ref({ title: '', body: '' });
    const errorMessage = ref('');
    const imageFile = ref(null);

    const closeModal = () => {
      emit('close-modal', 'save-post');
    };

    const onImageChange = (event) => {
      const file = event.target.files[0];
      imageFile.value = file;
    };

    const newPostAlert = () => {
      Swal.fire({
        icon: 'success',
        title: 'Post Successfully Created',
        timer: 1000,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
        },
        willClose: () => {
          closeModal();
        },
      });
    };


    const savePost = () => {newPostAlert
      const formData = new FormData();
      formData.append('title', fields.value.title);
      formData.append('body', fields.value.body);

      if (imageFile.value !== null) {
        formData.append('image', imageFile.value);
      }

      axios
        .post('/newPost', formData)
        .then((response) => {
          console.log(response.data);
          fields.value.title = '';
          fields.value.body = '';
          errorMessage.value = '';
          emit('save-post');
          newPostAlert();
    })
        .catch((error) => {

          Swal.fire({
              icon: 'success',
              title: 'Post error',
              text: 'Image size too big. Recommended less than 1mb',
              timer: 1000,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
              },
              willClose: () => {
                closeModal();
              },
            });
          console.error(error);
          errorMessage.value =
            'An error occurred while saving the post. Please try again later.';
        });
    };

    return {
      fields,
      errorMessage,
      imageFile,
      onImageChange,
      savePost,
      closeModal,
    };
  },
};
</script>

<style>
/* Add your modal styles here if needed */
</style>
