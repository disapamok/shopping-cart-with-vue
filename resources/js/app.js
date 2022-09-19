/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

// Customer view components
Vue.component('product-list',require('./components/ProductList.vue').default);
Vue.component('cart-view',require('./components/Cart.vue').default);
Vue.component('checkout',require('./components/Checkout.vue').default);

// Admin View Components
Vue.component('admin-products',require('./components/Admin/ManageProducts.vue').default);

Vue.mixin({
    methods : {
        showAlert : function(message){
            this.$swal(message);
        },
        ask : function(title, message, callback){
            this.$swal({
                title: (title == null ? "Are you sure?" : title),
                text: message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, do it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(callback);
        }
    }
});

const app = new Vue({
    el: '#app',
});
