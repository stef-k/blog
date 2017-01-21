/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// import Vue Router
import VueRouter from 'vue-router';
// Compoenents referenced in routes
import DashboardHome from './components/DashboardHome.vue';
import Newpost from './components/NewPost.vue';
import Editpost from './components/EditPost.vue';
import Posts from './components/Posts.vue';
import Projects from './components/Projects.vue';
import Library from './components/Library.vue';
import NotFound from './components/NotFound.vue';
import Security from './components/Security.vue';
import Integrations from './components/Integrations.vue';
// Declare global Dashboard which is used in main admin blade template
import Dashboard from './components/Dashboard.vue';
Vue.component('dashboard', Dashboard);

// Message bus for inter component communication
let bus = new Vue();
// Register it with Vue and reference it as widnow.bus
window.bus = bus;

// register router with Vue
Vue.use(VueRouter);

// declare our routes
const routes = [
  {path: '/', component: DashboardHome},
  {path: '/posts', component: Posts},
  {path: '/posts/:id', component: Editpost},
  {path: '/new-post', component: Newpost},
  {path: '/projects', component: Projects},
  {path: '/projects/:id', component: Editpost},
  {path: '/library', component: Library},
  {path: '/security', component: Security},
  {path: '/integrations', component: Integrations},
  // Not found (404 error)  page
  { path: '*', component: NotFound}
];

const router = new VueRouter({
  routes,
  mode           : 'history',
  linkActiveClass: 'is-active',
  base           : '/admin/'
});

const app = new Vue({
  router,
  el: '#app'
});
