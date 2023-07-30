<template>
  <!-- Modal -->
  <div class="modal" :class="{ 'is-active': showModalProp }">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-content">
      <div class="box">
        <h1 class="title">Register User</h1>
        <form @submit.prevent="registerUser">
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input class="input" type="text" v-model="formData.name" required autocomplete="current-name">
            </div>
          </div>

          <div class="field">
            <label class="label">Email</label>
            <div class="control">
              <input class="input" type="email" v-model="formData.email" required autocomplete="current-email">
            </div>
          </div>

          <div class="field">
            <label class="label">Password</label>
            <div class="control">
              <input class="input" type="password" v-model="formData.password" required autocomplete="current-password">
            </div>
          </div>

          <!-- Register Button -->
          <div class="field">
            <div class="control">
              <button class="button is-success">Register</button>
            </div>
          </div>
        </form>
        <!-- Show success message when registration is successful -->
        <div v-if="showSuccessMessage" class="has-text-success">{{ successMessage }}</div>
      </div>
    </div>
    <button class="modal-close is-large" aria-label="close" @click="closeModal"></button>
  </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
  props: {
    showModalProp: {
      type: Boolean,
      required: true,
    },
  },
  setup(props, { emit }) {
    const formData = ref({
      name: '',
      email: '',
      password: '',
    });

    const showSuccessMessage = ref(false); // Reactive property for showing the success message
    const successMessage = ref(''); // Reactive property to store the success message text

    const closeModal = () => {
      emit('close-modal');
    };

    const registerUser = async () => {
      try {
        const response = await axios.post('/register', formData.value);
        // Assuming the server returns a success message
        console.log(response.data.message);
        showSuccessMessage.value = true; // Show the success message
        successMessage.value = response.data.message; // Set the success message text
        // Clear the form fields after successful registration
        formData.value.name = '';
        formData.value.email = '';
        formData.value.password = '';
      } catch (error) {
        console.error(error);
        // Handle error here (show error message, etc.)
      }
    };

    // Return the data and methods you want to expose in the template
    return {
      formData,
      closeModal,
      registerUser,
      showSuccessMessage,
      successMessage,
    };
  },
});
</script>

<style>
/* Add custom styling for the modal as needed */
</style>
