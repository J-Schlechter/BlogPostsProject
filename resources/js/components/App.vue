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
    <AllPosts :posts="postsData" :current-user="currentUser" />
  </div>
</template>

<script>
import { defineComponent, ref, onMounted, computed } from 'vue';
import axios from 'axios';
import Navbar from './navbar.vue';
import ConfirmationModal from './ConfirmationModal.vue';
import NewPostModal from './NewPostModal.vue';
import RegisterUser from './RegisterUser.vue';
import LoginModal from './LoginModal.vue';
import AllPosts from './allPosts.vue';
import Swal from 'sweetalert2';


export default defineComponent({
  components: {
    Navbar,
    ConfirmationModal,
    NewPostModal,
    RegisterUser,
    LoginModal,
    AllPosts,
  },

  setup( props, {emit}) {
    const isNewPostModalVisible = ref(false);
    const isConfirmationModalVisible = ref(false);
    const showNewPostModal = ref(false);
    const showRegisterModal = ref(false);
    const showLoginModal = ref(false);
    const isAuthenticated = ref();
    const currentUser = ref();
    const errorMessage = ref('');
    const postsData = ref([]);

    const chosenPost = ref('allPosts');

    const currentUserName = computed(() => {
      return currentUser.value ? currentUser.value : 'Guest';
    });

    const allPostBreadcrumb = () => {
      chosenPost.value = 'allPosts';
      console.log(chosenPost.value)
    };

    const userPostBreadcrumb = () => {
      chosenPost.value = 'userPosts';
      console.log(chosenPost.value)
    };

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
      showNewPostModal.value = false;
      emit('save-post');
    };

    const handlePostSaved = () => {
      alert('New post created successfully!');
    };

    const handlePostSaveError = (error) => {
      console.error('Error saving new post:', error);
      alert('An error occurred while saving the new post. Please try again later.');
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
      isAuthenticated.value = true;
      currentUser.value = data.name;
      closeLoginModal();
      Swal.fire({
        icon: 'success',
        title: 'User Successfully Logged in.',
        timer: 1000,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
        },
        willClose: () => {},
      });
    };

    const viewAllPosts = () => {
      allPostBreadcrumb();
      chosenPost.value = 'allPosts';
      axios
        .get('/posts')
        .then((response) => {
          postsData.value = response.data;
        })
        .catch((error) => {
          console.error('Error fetching posts data:', error);
        });
    };

    const viewUserPosts = () => {
      userPostBreadcrumb();
      chosenPost.value = 'userPosts';
      axios
        .get('/yourPosts')
        .then((response) => {
          postsData.value = response.data;
          console.log(postsData.value);
        })
        .catch((error) => {
          console.error('Error fetching posts data:', error);
        });
    };

    onMounted(() => {
      viewUserPosts();
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
      handleLoginSuccess,
      currentUserName,
      logout,
      postsData,
      handlePostSaved,
      chosenPost,
      allPostBreadcrumb,
      userPostBreadcrumb,
      viewAllPosts,
      viewUserPosts,
    };
  },
});
</script>

<style>
/* Add your custom styles here */
</style>
