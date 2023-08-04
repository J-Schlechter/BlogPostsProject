<template>
  <nav class="navbar is-primary is-touch" role="navigation" aria-label="main navigation">
    <!-- Navbar brand/logo -->
    <!-- ... Your brand/logo HTML code ... -->

    <!-- Navbar menu items -->
    <div id="navbarBlog" class="navbar-menu" :class="{ 'is-active': isMenuOpen }">
      <div class="navbar-start">
        <a class="navbar-item" href="/">Home</a>
        <a class="navbar-item">|</a> <!-- Debug: Display isAuthenticated -->
        <template v-if="isAuthenticated" class="logged">
          <a class="navbar-item">
            <button @click="openNewPostModal" class="button is-success">New Post</button>
          </a>
        </template>
      </div>
      <div class="navbar-end">
        <!-- Show different content based on the authentication status -->
        <div></div>
        <template v-if="isAuthenticated" >
          
          <!-- Show logout button when logged in -->
          <div class="navbar-item logged-in-button">
          <div class="navbar-item logged-in-text">Logged in as {{ currentUser }}   </div>
          <button class="button is-danger" @click="logout">Log Out</button>
        </div>
        </template>
        
        <template v-else>
          <div>
            
            <div class="buttons logged-out-button">
              <div class="navbar-item logged-out-text">Not Logged in</div>
              <button class="button is-info" @click="openLoginModal">Log In</button>
              <button class="button is-warning" @click="openRegisterModal">Register</button>
            </div>
          </div>
        </template>
      </div>
    </div>
  </nav>
  <br>
</template>

<script>
import { defineComponent, computed, ref } from 'vue';

export default {
  emits: [
    'open-new-post-modal',
    'open-login-modal',
    'open-register-modal',
    'logout',
    'login-success',
  ],
  props: { isMenuOpen : { type: Boolean }, isAuthenticated : { type: Boolean }, currentUser : {type: String} },
  
  
  setup(props, { emit }) {
    // Destructure the props directly
    const { isMenuOpen, isAuthenticated, currentUser } = props;
    
    // Computed property to get the current user's name or 'Guest' when not authenticated
    const currentUserName = computed(() => {
      return isAuthenticated ? currentUser.name : 'Guest';
    });

    // Methods
    const openNewPostModal = () => {
      emit('open-new-post-modal');
    };

    const openRegisterModal = () => {
      emit('open-register-modal');
    };

    const openLoginModal = () => {
      emit('open-login-modal');
    };

    const logout = () => {
      emit('logout');
    };

    return {
      // Reactive data
      currentUserName,
      
      // Methods
      openNewPostModal,
      openRegisterModal,
      openLoginModal,
      logout,
    };
  },
};
</script>

<style>
.logged-in-button, .logged-out-button {
  padding-right: 10px;
  padding-left: 10px;
  padding-top: 10px;
  padding-bottom: 10px;
}
.logged-in-text, .logged-out-text {
  padding-right: 20px;
  padding-left: 10px;
  padding-top: 10px;
  padding-bottom: 20px;
}
</style>
