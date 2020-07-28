require('./bootstrap');
import Vue from 'vue'

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

//Vue bootstrap
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

require("./register_component");

const app = new Vue({
    el: '#app',
});
