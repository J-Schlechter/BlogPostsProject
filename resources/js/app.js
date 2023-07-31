import { createApp, ref } from 'vue';
import App from './components/App.vue';
import navbar from './components/navbar.vue';
import breadcrumb from './components/breadcrumb.vue';
import allPosts from './components/allPosts.vue';
import NewPostModal from './components/NewPostModal.vue';
import RegisterUser from './components/RegisterUser.vue';
import LoginModal from './components/LoginModal.vue';
import { isAuthenticated } from './components/src/auth.js';
import axios from 'axios';

axios.interceptors.request.use(
  (config) => {
    // Get the authentication token from wherever you have stored it (e.g., Vuex store or localStorage)
    const authToken = localStorage.getItem('authToken');
    if (authToken) {
      config.headers['Authorization'] = `Bearer ${authToken}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

const app = createApp(App);
app.component('navbar', navbar);
app.component('breadcrumb', breadcrumb);
app.component('allPosts', allPosts);
app.component('NewPostModal', NewPostModal);
app.component('RegisterUser', RegisterUser);
app.component('LoginModal', LoginModal);

// Define a reactive ref for isAuthenticated
const isAuthenticatedRef = ref(isAuthenticated.value);

// Make isAuthenticated a reactive global property
app.config.globalProperties.isAuthenticated = isAuthenticatedRef;

app.mount('#app');
