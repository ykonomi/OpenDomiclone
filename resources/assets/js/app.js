
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vue.use(require('vuex'));



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('navbar', require('./components/Navbar.vue'));

Vue.component('start', require('./components/Start.vue'));
Vue.component('front', require('./components/Front.vue'));


Vue.component('card', require('./components/Card.vue'));
Vue.component('balloon', require('./components/Balloon.vue'));

Vue.component('hand', require('./components/Hand.vue'));
Vue.component('supply', require('./components/Supply.vue'));
Vue.component('playarea', require('./components/PlayArea.vue'));
Vue.component('disposal', require('./components/Disposal.vue'));
Vue.component('public', require('./components/Public.vue'));


Vue.component('modal', require('./components/Modal.vue'));
Vue.component('debug', require('./components/Debug.vue'));

Vue.component('ui-test', require('./components/UItest.vue'));
Vue.component('user-input', require('./components/UserInput.vue'));
Vue.component('system-log', require('./components/SystemLog.vue'));
Vue.component('action-hands', require('./components/ActionHands.vue'));
Vue.component('buy-hands', require('./components/BuyHands.vue'));



import phase from './store/modules/phase'
import log from './store/modules/log'
import game from './store/modules/game'
import Vuex from 'vuex'


const store = new Vuex.Store({
  modules: {
      phase,
      log,
      game,
  },
  strict: true,
})

const app = new Vue({
    el: '#app',
    store,
});

