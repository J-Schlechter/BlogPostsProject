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
    <NewPostModal :show-New-Post-Prop="showNewPostModal" @open-modal="openNewPostModal" @close-modal="closeNewPostModal"  />
    <LoginModal :show-Login-Modal="showLoginModal" @open-modal="openLoginModal" @close-modal="closeLoginModal"  @login-success="handleLoginSuccess"/> <!-- Pass the login-success event handler -->
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
import Swal from 'sweetalert2'

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
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            Swal.fire('Logged out!', '', 'success')
            axios.post('/logout')
            .then(response => {
              localStorage.removeItem('authToken');
              isAuthenticated.value = false;
              currentUser.value = null;
              console.log(response.data);
              // Reset fields and error message after successful post creation
              errorMessage.value = '';
              
            })
            .catch(error => {
              console.error(error);
              // Set the error message when an error occurs during post saving
              errorMessage.value = 'An error occurred while logging out. Please try again later.';
            });
          } else if (result.isDenied) {
            
          }
        });
    };
        
   const openNewPostModal = () => {
      showNewPostModal.value = true;
    };

    const closeNewPostModal = () => {
      showNewPostModal.value = false;
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
      axios.post('/newPost', fields.value)
        .then(response => {
          console.log(response.data);
          // Reset fields and error message after successful post creation
          fields.value.title = '';
          fields.value.body = '';
          errorMessage.value = '';
          newPostAlert();
        })
        .catch(error => {
          console.error(error);
          // Set the error message when an error occurs during post saving
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
