<template>
  <div>
    <Navbar
      :isMenuOpen="isMenuOpen"
      
      :currentUser="currentUser"
      :isAuthenticated="isAuthenticated"
      @open-new-post-modal="openNewPostModal"
      @open-login-modal="openLoginModal"
      @open-register-modal="openRegisterModal"
      @logout="logout"
      @login-success="handleLoginSuccess"  />
    <ConfirmationModal :is-active="isConfirmationModalVisible" @confirmed="deletePost" @canceled="hideConfirmationModal" />
    <NewPostModal :is-active="isNewPostModalVisible" @open-modal="openNewPostModal" @close-modal="closeNewPostModal" />
    <LoginModal :is-active="isLoginModalVisible" @open-modal="openLoginModal" @close-modal="closeLoginModal" @login-success="handleLoginSuccess" /> <!-- Pass the login-success event handler -->
    <RegisterUser :show-modal-prop="showRegisterModal" @open-modal="openRegisterModal" @close-modal="closeRegisterModal" />
    <AllPosts :posts="postsData" :current-user="currentUser" />
  </div>
</template>

<script>
import { defineComponent, ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Navbar from './navbar.vue';
import ConfirmationModal from './ConfirmationModal.vue';
import NewPostModal from './NewPostModal.vue';
import RegisterUser from './RegisterUser.vue';
import LoginModal from './LoginModal.vue';
import AllPosts from './allPosts.vue';

export default defineComponent({
  components: {
    Navbar,
    ConfirmationModal,
    NewPostModal,
    RegisterUser,
    LoginModal,
    AllPosts,
  },
  setup() {
    const isNewPostModalVisible = ref(false);
    const isConfirmationModalVisible = ref(false);
    const showNewPostModal = ref(false);
    const showRegisterModal = ref(false);
    
    const isAuthenticated = ref(false);
    const currentUser = ref(null);

    const currentUserName = computed(() => {
      
      return currentUser.value ? currentUser.value : 'Guest';
    });

    const logout = () => {
      localStorage.removeItem('authToken');
      localStorage.removeItem('isAuthenticated');
      localStorage.removeItem('userName');
      isAuthenticated.value = false;
      currentUser.value = null;
    };

    const openNewPostModal = () => {
      isNewPostModalVisible.value = true;
    };

    const closeNewPostModal = () => {
      isNewPostModalVisible.value = false;
    };

    const handlePostSaved = (postData) => {
      console.log('New post data:', postData);
      closeNewPostModal();
      fields.title = '';
      fields.body = '';
      alert('New post created successfully!');
    };

    const handlePostSaveError = (error) => {
      console.error('Error saving new post:', error);
      alert('An error occurred while saving the new post. Please try again later.');
    };

    const newPost = () => {
      axios
        .post('/api/posts', fields.value) // Change the API endpoint to match your backend route for creating posts
        .then((response) => {
          handlePostSaved(response.data);
        })
        .catch((error) => {
          handlePostSaveError(error);
        });
    };

    const openRegisterModal = () => {
      showRegisterModal.value = true;
    };

    const closeRegisterModal = () => {
      showRegisterModal.value = false;
    };

    const deletePost = () => {
      hideConfirmationModal();
    };

    const hideConfirmationModal = () => {
      isConfirmationModalVisible.value = false;
    };

    const isLoginModalVisible = ref(false);

    const openLoginModal = () => {
      isLoginModalVisible.value = true;
    };

    const closeLoginModal = () => {
      isLoginModalVisible.value = false;
    };

    const handleLoginSuccess = (data) => {
      console.log('API Response:', data);
      isAuthenticated.value = true;
      currentUser.value = data.name;
      
      
      //userData.currentUser = userData.name; // Assuming the API response contains user data with 'id', 'name', 'email', etc.
      //console.log('API data', userData.currentUser, );
      closeLoginModal();
    };

    

    const postsData = ref([]);

    onMounted(() => {
      axios
        .get('/posts') // Change the API endpoint to match your backend route for fetching posts
        .then((response) => {
          
          postsData.value = response.data;
        })
        .catch((error) => {
          console.error('Error fetching posts data:', error);
        });
    });

    return {
      isNewPostModalVisible,
      isConfirmationModalVisible,
      showRegisterModal,
      showNewPostModal,
      closeNewPostModal,
      openRegisterModal,
      closeRegisterModal,
      deletePost,
      hideConfirmationModal,
      openNewPostModal,
      closeLoginModal,
      openLoginModal,
      isLoginModalVisible,
      isMenuOpen: ref(false),
      isAuthenticated,
      currentUser,
      newPost,
      handleLoginSuccess,
      currentUserName,
      logout,
      postsData,
    };
  },
});
</script>
