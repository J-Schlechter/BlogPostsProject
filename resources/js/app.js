import { createApp } from 'vue';

import App from './components/App.vue';
import helloworld from './components/helloworld.vue';
import navbar from './components/navbar.vue';


const app = createApp(App);
// Register the 'hello' component globally
app.component('hello', helloworld);

// Uncomment the line below if you want to use the 'navigation' component globally
app.component('navigation', navbar);

// Create the Vue app instance


// Mount the app to a DOM element with the id 'app'
app.mount('#app');
