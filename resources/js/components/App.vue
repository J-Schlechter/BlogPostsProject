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
      <breadcrumb
        :chosenPost="chosenPost"
        :currentUser="currentUser"
        @choose-post="handleChoosePost"
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
      <AllPosts v-if="postsIsActive" :posts="allPostsData" :current-user="currentUser" />
      <UserPosts v-if="userPostsIsActive" :posts="userPostsData" :current-user="currentUser" />
    </div>
  </template>

  <script>
  import { defineComponent, ref, onMounted, computed, provide } from 'vue';

  import axios from 'axios';
  import Navbar from './navbar.vue';
  import ConfirmationModal from './ConfirmationModal.vue';
  import NewPostModal from './NewPostModal.vue';
  import RegisterUser from './RegisterUser.vue';
  import LoginModal from './LoginModal.vue';
  import AllPosts from './allPosts.vue';
  import UserPosts from './userPosts.vue';
  import breadcrumb from './breadcrumb.vue';
  import Swal from 'sweetalert2';

  export default defineComponent({
    components: {
      Navbar,
      ConfirmationModal,
      NewPostModal,
      RegisterUser,
      LoginModal,
      AllPosts,
      UserPosts,
      breadcrumb,
    },

    setup(props, { emit }) {
      const isNewPostModalVisible = ref(false);
      const isConfirmationModalVisible = ref(false);
      const showNewPostModal = ref(false);
      const showRegisterModal = ref(false);
      const showLoginModal = ref(false);
      const isAuthenticated = ref();
      const currentUser = ref();
      const errorMessage = ref('');
      const allPostsData = ref([]); // Separate data array for all posts
      const userPostsData = ref([]); // Separate data array for user posts
      const postsCount = ref();
      const postsIsActive = ref(true);
      const userPostsIsActive = ref(false);
      const dataFromParent = ref('');
      const chosenPost = ref('allPosts');

      const currentUserName = computed(() => {
            if (this.isAuthenticated) {
            const savedUserData = localStorage.getItem('userData');
            if (savedUserData) {
            try {
                const parsedUserData = JSON.parse(savedUserData);
                if (parsedUserData.name) {
                console.log(parsedUserData.name)
                return parsedUserData.name;
                } else {
                // Handle the case where name is missing in parsedUserData
                return 'Guest';
                }
            } catch (error) {
                console.error('Error parsing savedUserData:', error);
                return 'Guest';
            }
            }
        } else {
            return 'Guest';
        }
      });

      const allPostBreadcrumb = () => {
        postsIsActive.value = true;
        userPostsIsActive.value = false;
      };

      const userPostBreadcrumb = () => {
        postsIsActive.value = false;
        userPostsIsActive.value = true;
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

      const resetData = () => {

        dataFromParent.value = '';

      };

      const closeNewPostModal = () => {
        showNewPostModal.value = false;
        location.reload();

        resetData();
      };
      provide('dataFromParent', dataFromParent);
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

        //localStorage.setItem('authToken', data.token);
        localStorage.setItem('userData', JSON.stringify(data.name));
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

      const handleChoosePost = (postType) => {
        chosenPost.value = postType;

        if (postType === 'allPosts') {
          allPostBreadcrumb();
          viewAllPosts(); // Load all posts
        } else if (postType === 'userPosts') {
          userPostBreadcrumb();
          viewUserPosts(); // Load user-specific posts
        }
      };

      const viewAllPosts = () => {
        axios
          .get('/posts')
          .then((response) => {
            allPostsData.value = response.data;
          })
          .catch((error) => {
            console.error('Error fetching all posts data:', error);
          });
      };

      const viewUserPosts = () => {
        axios
          .get('/userPosts')
          .then((response) => {
            userPostsData.value = response.data;
            console.log(userPostsData.value);
          })
          .catch((error) => {
            console.error('Error fetching user posts data:', error);
          });
      };

      onMounted(() => {
        const savedToken = localStorage.getItem('authToken');
        currentUser.name = localStorage.getItem('userData');

        if (savedToken && currentUser.name) {
            isAuthenticated.value = true;
            try {

            if (currentUser.name) {
                currentUser.value = currentUser.name.replace(/^"/,"").replace(/"$/,"");
            } else {
                // Handle the case where name is missing in parsedUserData
            }
            } catch (error) {
            console.error('Error parsing savedUserData:', error);
            }
        } else {
            // Handle the case where savedToken or savedUserData is missing
        }

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
        allPostsData,
        userPostsData,
        handlePostSaved,
        chosenPost,
        allPostBreadcrumb,
        userPostBreadcrumb,
        viewAllPosts,
        viewUserPosts,
        handleChoosePost,
        postsIsActive,
        userPostsIsActive,
      };
    },
  });
  </script>

  <style>
  /* Add your custom styles here */
  </style>
