require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/App.vue'

const router = new VueRouter({
  mode: 'history',
  routes: [
        
  ],
})

new Vue({
  el: '#app',
  components: { App },
  router,
});

// const app = createApp(App);
// app.config.globalProperties.$axios = axios;
// app.use(router);
// app.mount('#app');