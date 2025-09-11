/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


import Vue from 'vue/dist/vue.min.js'
import components from "./components";
import route from "ziggy";
import {Ziggy} from "./routes";
import {ServerTable} from "vue-tables-2";
import tablesConfig from "./tables_config";
import flatPickr from "vue-flatpickr-component";
import 'flatpickr/dist/flatpickr.css';
import VModal from "vue-js-modal";
import ALVue from "@myshell/alvue";
import moment from 'moment';
import VueToast from 'vue-toast-notification';
import swal from 'sweetalert2';
import VueSweetalert2 from 'vue-sweetalert2';
import VueFileAgent from 'vue-file-agent';
import VueNumberFormat from 'vue-number-format';
import 'line-awesome/dist/line-awesome/css/line-awesome.min.css';
import ToggleButton from 'vue-js-toggle-button';

import money from 'v-money';


moment.locale('es-mx');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.use(ServerTable, tablesConfig.options);
Vue.mixin(tablesConfig.init);
Vue.use(flatPickr);
Vue.use(VueFileAgent);
Vue.use(VueToast);
Vue.use(VModal, {dialog: true});
Vue.use(ALVue);
Vue.use(VueSweetalert2);
Vue.use(VueNumberFormat, {prefix: 'R$ ', decimal: ',', thounsand: '.'});
Vue.use(ToggleButton);
Vue.use(money, {
    precision: 2,
    decimal: '.',
    thousands: ',',
    prefix: '$',
    suffix: '',
    masked: false
});




Vue.mixin({
    data() {
        return {
            swal: swal,
        }
    },
    methods: {
        $moment: moment,
        $route: (name, params, absolute) => route(name, params, absolute, Ziggy),
    }
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: components
});
