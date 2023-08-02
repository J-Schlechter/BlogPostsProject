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
      @login-success="handleLoginSuccess"
    />
    <ConfirmationModal
      :is-active="isConfirmationModalVisible"
      @confirmed="deletePost"
      @canceled="hideConfirmationModal"
    />
    <NewPostModal
      :show-New-Post-Prop="showNewPostModal"
      @open-modal="openNewPostModal"
      @close-modal="closeNewPostModal"
    />
    <LoginModal
      :show-Login-Modal="showLoginModal"
      @open-modal="openLoginModal"
      @close-modal="closeLoginModal"
      @login-success="handleLoginSuccess"
    />
    <RegisterUser
      :show-modal-prop="showRegisterModal"
      @open-modal="openRegisterModal"
      @close-modal="closeRegisterModal"
    />
    <AllPosts :posts="postsData" :current-user="currentUser" @load-posts="loadPosts" />
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
import Swal from 'sweetalert2';

export default defineComponent({
  emits: ['open-new-post-modal', 'open-login-modal', 'open-register-modal'],
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
    const showLoginModal = ref(false);
    const isAuthenticated = ref(false);
    const currentUser = ref(null);
    const errorMessage = ref('');
    const currentUserName = computed(() => {
      return currentUser.value ? currentUser.value : 'Guest';
    });

    const logout = () => {
      Swal.fire({
        title: 'Are you sure you want to log out?',
        showCancelButton: true,
        confirmButtonText: 'Log Out',
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire('Logged out!', '', 'success');
          axios
            .post('/logout')
            .then((response) => {
              localStorage.removeItem('authToken');
              isAuthenticated.value = false;
              currentUser.value = null;
              errorMessage.value = '';
            })
            .catch((error) => {
              console.error(error);
              errorMessage.value =
                'An error occurred while logging out. Please try again later.';
            });
        } else if (result.isDenied) {
          // Handle cancel
        }
      });
    };

    const openNewPostModal = () => {
      showNewPostModal.value = true;
    };

    const closeNewPostModal = () => {
      post.$forceUpdate();
      showNewPostModal.value = false;
    };

    const handlePostSaved = (postData) => {
      console.log('New post data:', postData);
      closeNewPostModal();
      // Assuming fields is a ref that holds post data
      fields.value.title = '';
      fields.value.body = '';
      
      alert('New post created successfully!');
    };

    const handlePostSaveError = (error) => {
      console.error('Error saving new post:', error);
      alert('An error occurred while saving the new post. Please try again later.');
    };

    const newPost = () => {
      axios
        .post('/newPost', fields.value)
        .then((response) => {
          console.log(response.data);
          fields.value.title = '';
          fields.value.body = '';
          errorMessage.value = '';
          this.$forceUpdate();
        })
        .catch((error) => {
          console.error(error);
          errorMessage.value = 'An error occurred while saving the post. Please try again later.';
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

    const openLoginModal = () => {
      showLoginModal.value = true;
    };

    const closeLoginModal = () => {
      showLoginModal.value = false;
    };

    const handleLoginSuccess = (data) => {
      console.log('API Response:', data);
      isAuthenticated.value = true;
      currentUser.value = data.name;
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
      showLoginModal,
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

<style>
/* Add your custom styles here */
</style>
