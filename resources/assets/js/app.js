
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('front',      require('./components/DomicronFront.vue'));
Vue.component('navbar', require('./components/Navbar.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('debug', require('./components/Debug.vue'));
Vue.component('action1', require('./components/Action1.vue'));

Vue.component('ui-test', require('./components/UItest.vue'));
Vue.component('user-input', require('./components/UserInput.vue'));
Vue.component('system-log', require('./components/SystemLog.vue'));
Vue.component('card', require('./components/Card.vue'));
Vue.component('action-hands', require('./components/ActionHands.vue'));
Vue.component('buy-hands', require('./components/BuyHands.vue'));


const app = new Vue({
    el: '#app'
});
