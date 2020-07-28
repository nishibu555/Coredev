import Vue from 'vue'
Vue.component('update-status', require('./components/Modal/UpdateStatus').default);
Vue.component('change-password-form', require('./components/ChangePasswordForm.vue').default)
Vue.component('active-inactive-user', require('./components/Modal/ActiveInactiveUser').default);
Vue.component('comms-log-content-view', require('./components/Modal/CommsLogContentView').default);
Vue.component('show-events', require('./components/ShowEvents').default);
Vue.component('show-timeline', require('./components/ShowTimeline').default);
Vue.component('show-wishes', require('./components/ShowWishes').default);
Vue.component('show-gifts', require('./components/ShowGifts').default);
