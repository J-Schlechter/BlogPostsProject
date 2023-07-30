<template>
  <div class="modal" :class="{ 'is-active': isActive }">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-content">
      <div class="box">
        <h1 class="title">Log In</h1>
        <form @submit.prevent="login">
          <div class="field">
            <label class="label">Username</label>
            <div class="control">
              <input class="input" v-model="username" type="text" placeholder="Enter your name" autocomplete="name" name="username" required>
            </div>
          </div>

          <div class="field">
            <label class="label">Password</label>
            <div class="control">
              <input class="input" v-model="password" type="password" placeholder="Enter your password" autocomplete="current-password" name="password" required>
            </div>
          </div>

          <!-- Show error message when login fails -->
          <div v-if="showErrorMessage" class="has-text-danger">{{ errorMessage }}</div>

          <button class="button is-success">Log In</button>
        </form>
      </div>
    </div>
    <button class="modal-close is-large" aria-label="close" @click="closeModal"></button>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import axios from 'axios';

// Define the props and emits using the setup argument
const { isActive } = defineProps(['isActive']);
const emit = defineEmits();

const username = ref('');
const password = ref('');
const showErrorMessage = ref(false);
const errorMessage = ref('');

const login = () => {
  const loginData = {
    name: username.value,
    password: password.value,
  };

  axios
    .post('/login', loginData)
    .then((response) => {
      console.log('login response', response)
      const authToken = response.data.token;
      localStorage.setItem('authToken', authToken);

      // Emit the login-success event with the user data
      const userData = response.data.user;
      console.log(userData);
      emit('login-success', userData);

      closeModal(); // Close the modal after successful login
    })
    .catch((error) => {
      console.error(error);
      if (error.response && error.response.data && error.response.data.errors) {
        // Handle specific error messages returned by the API
        // For example, you can display the first error message returned by the API
        showErrorMessage.value = true;
        errorMessage.value = Object.values(error.response.data.errors)[0][0];
      } else {
        // Handle generic error message
        showErrorMessage.value = true;
        errorMessage.value = 'An error occurred during login. Please try again later.';
      }
    });
};

const closeModal = () => {
  emit('update:isActive', false); // Emit the event to update the 'isActive' prop
};
</script>

<style>
/* Add your modal styles here, e.g., centering the modal */
</style>
