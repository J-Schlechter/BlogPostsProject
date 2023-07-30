// auth.js
// This is a simple example, you may need to adjust it based on your actual authentication mechanism

import { ref } from 'vue';

// Simulate an asynchronous login request to the server
const fakeLogin = (username, password) => {
  return new Promise((resolve, reject) => {
    // Simulate a delay to simulate server response time
    setTimeout(() => {
      if (username === 'user' && password === 'password') {
        resolve({ name: 'User' }); // Assuming the API returns user data on successful login
      } else {
        reject(new Error('Invalid credentials'));
      }
    }, 1000);
  });
};

// Simulate an asynchronous logout request to the server
const fakeLogout = () => {
  return new Promise((resolve) => {
    // Simulate a delay to simulate server response time
    setTimeout(() => {
      resolve();
    }, 500);
  });
};

export const isAuthenticated = ref(false);

export const login = async (username, password) => {
  try {
    const userData = await fakeLogin(username, password);
    isAuthenticated.value = true;
    return userData;
  } catch (error) {
    isAuthenticated.value = false;
    throw error;
  }
};

export const logout = async () => {
  try {
    await fakeLogout();
    isAuthenticated.value = false;
  } catch (error) {
    // Handle logout error if needed
    throw error;
  }
};
