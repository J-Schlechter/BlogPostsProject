<template>
  <!-- Modal -->
  <div class="modal" :class="{ 'is-active': showModalProp }">
    <div class="modal-background" @click="closeModal"></div>
    <div class="modal-content">
      <div class="box">
        <h1 class="title">Register User</h1>
        <form @submit.prevent="submitForm">
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input class="input" type="text" v-model="formData.name" required autocomplete="current-name">
            </div>
            <div v-if="errors.name" class="has-text-danger">{{ errors.name }}</div>
          </div>

          <div class="field">
            <label class="label">Email</label>
            <div class="control">
              <input class="input" type="email" v-model="formData.email" required autocomplete="current-email">
            </div>
            <div v-if="errors.email" class="has-text-danger">{{ errors.email }}</div>
          </div>

          <div class="field">
            <label class="label">Password</label>
            <div class="control">
              <input class="input" type="password" v-model="formData.password" required autocomplete="current-password">
            </div>
            <div v-if="errors.password" class="has-text-danger">{{ errors.password }}</div>
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
import { defineComponent, ref, emit } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

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

    const errors = ref({
      name: '',
      email: '',
      password: '',
    }); // Reactive object to store form field validation errors

    const closeModal = () => {
      emit('close-modal');
    };

    const isValidEmail = (email) => {
      // You can use a regular expression or any other validation logic here
      // This is a simple example that checks for a valid email format
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    };

    const validateForm = () => {
      errors.value = {
        name: formData.value.name.trim() === '' ? 'Name is required.' : '',
        email: !isValidEmail(formData.value.email.trim()) ? 'Please enter a valid email address.' : '',
        password: formData.value.password.trim() === '' ? 'Password is required.' : '',
      };
    };

    const submitForm = async () => {
      validateForm();

      // Check if any field is invalid
      if (Object.values(errors.value).some((error) => error !== '')) {
        return; // Abort registration if any field is invalid
      }

      axios
        .post('/register', formData.value)
        .then((response) => {
          emit('close-modal')
          if (response.data.message === 'Registration successful') {
            Swal.fire({
                icon: 'success',
                title: 'User Successfully Registered.',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading();
                },
                willClose: () => {
                  
                },
              });
            const userData = response.data.user;
            formData.value.name = '';
            formData.value.email = '';
            formData.value.password = '';
            errors.value = {
              name: '',
              email: '',
              password: '',
            };
            emit('close-modal');
            closeModal(); // Close the modal after successful login
          } else {
            console.error('Registration failed:', response.data.message);
          }
        })
        .catch((error) => {
          console.error('Error during registration:', error);
        });
    };

    // Return the data and methods you want to expose in the template
    return {
      formData,
      closeModal,
      submitForm,
      showSuccessMessage,
      successMessage,
      errors,
    };
  },
});
</script>

<style>
/* Add custom styling for the modal as needed */
</style>