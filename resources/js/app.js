require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';

// Add SweetAlert
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

// Add Vue-i18n for language support.
import VueI18n from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';

var language = localStorage.getItem("lang");
language = (language == '' ? 'en' : language);

const i18n = new VueI18n({
    locale: language,
    messages : Locale,
});

// Customer view components
Vue.component('product-list',require('./components/ProductList.vue').default);
Vue.component('cart-view',require('./components/Cart.vue').default);
Vue.component('order-history',require('./components/OrderHistory.vue').default);

// Admin View Components
Vue.component('admin-products',require('./components/Admin/ManageProducts.vue').default);
Vue.component('sales-report',require('./components/Admin/Report.vue').default);

// Mixin Function
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
    i18n
});
