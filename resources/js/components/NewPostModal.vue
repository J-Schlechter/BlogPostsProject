<template>
  <div class="modal" :class="{ 'is-active': showNewPostProp }">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-content">
      <div class="box">
        <form @submit.prevent="savePost">
          <div class="field">
            <input class="input pb-2" v-model="fields.title" type="text" id="title" name="title" placeholder="Your post's title" style="width: 70%" required>
          </div>

          <div class="field">
            <textarea class="textarea" v-model="fields.body" id="body" name="body" placeholder="Write your post here!" style="width: 65%" required></textarea>
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
import {  ref, emit } from 'vue';
import Swal from 'sweetalert2'

export default ({
  emits: ['close-modal', 'open-modal'],
  props: {
    showNewPostProp: {
      type: Boolean,
      
    },
  },
  
  setup(props, {emit}) {
    const fields = ref({ title: '', body: '' });
    const errorMessage = ref(''); // Reactive property for error message
    
    const closeModal = () => {
      // Emit the 'close-modal' event to parent component
      emit('close-modal');
    };

    const newPostAlert = () => {
      let timerInterval
      Swal.fire({
      icon: 'success',
      title: 'Post Succesfull',
      html:'<b></b>',
      timer: 1000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
          b.textContent = Swal.getTimerLeft()
        }, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    });
    closeModal();
    };

    const savePost = () => {
      axios
        .post('/newPost', fields.value)
        .then((response) => {
          console.log(response.data);
          // Reset fields and error message after successful post creation
          fields.value.title = '';
          fields.value.body = '';
          errorMessage.value = '';
          closeModal(); 
          newPostAlert();// Close the modal after successful post creation
        })
        .catch((error) => {
          console.error(error);
          // Set the error message when an error occurs during post saving
          errorMessage.value =
            'An error occurred while saving the post. Please try again later.';
        });
    };

    return {
      fields,
      errorMessage,
      savePost,
      closeModal,
    };
  },
});
</script>
