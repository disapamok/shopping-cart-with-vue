<template>
    <div class="container the-cart">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center">{{ $t('general.cart.title') }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 cart-item" v-for="item in cartItems" :key="item.id">
                <div class="flexbox">
                    <img :src="item.product.image" width="64"/>
                    <div class="prod-name">
                        <h4>{{item.product.name}}</h4>
                        <p>{{item.product.category.name}}</p>
                    </div>
                    <h6><i>{{ $t('general.cart.quantity') }}: {{item.qty}}</i></h6>
                    <h6>Rs. {{item.product.price.toFixed(2)}}</h6>
                    <h6>Rs. {{(item.product.price * item.qty).toFixed(2)}}</h6>
                    <button class="btn btn-sm btn-danger" v-on:click="remove(item)">{{ $t('general.cart.remove') }}</button>
                </div>
            </div>
            <div class="col-lg-12" v-if="cartItems.length == 0">
                <div class="alert alert-warning text-center">{{ $t('general.cart.empty') }}</div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-3 float-right">
                <table class="cart-total">
                    <tr>
                        <span>{{ $t('general.cart.total') }}:</span>
                        <span class="float-right">{{cartTotal}}</span>
                    </tr>
                    <tr>
                        <span>{{ $t('general.cart.discounts') }}:</span>
                        <span class="float-right">{{ $t('general.cart.lkr') }}: 0</span>
                    </tr>
                    <tr>
                        <span>{{ $t('general.cart.total_payble') }}:</span>
                        <span class="float-right">{{cartTotal}}</span>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button v-if="cartItems.length > 0" v-on:click="checkout()"  class="btn btn-danger center checkout-now">{{ $t('general.cart.checkout') }}</button>
            </div>
            <div class="col-lg-12 d-flex justify-content-center">
                <a href="/" class="btn btn-sm btn-primary mr-1">{{ $t('general.cart.back_to_products') }}</a>
                <a href="/cart/order-history" class="btn btn-sm btn-success ml-1">{{ $t('general.cart.view_order_history') }}</a>
            </div>
        </div>
    </div>
</template>

<script>
import VueI18n from 'vue-i18n';
export default{
    data(){
        return{
            cartItems : []
        }
    },
    props: [
        'cart'
    ],
    mounted(){
        console.log(this.cart.items);
        this.cartItems = this.cart.items;
    },
    methods: {
        remove : function(item){
            this.ask(null, this.$t('general.cart.item_removed'), function (action){
                if(action.isConfirmed){
                    axios.delete('/cart/remove-item/'+item.id).then((response) => {
                        this.cartItems = this.cartItems.filter(function (ArItem){
                            return ArItem.id !== item.id;
                        });
                        this.showAlert(response.data.message);
                    }).catch((error) => {});
                }
            }.bind(this));
        },
        checkout : function (){
            var cartID = this.cart.id;
            this.ask(null, this.$t('general.cart.checkout_message'),function (action){
                if(action.isConfirmed){
                    axios.put('cart/do-checkout',{
                        cart_id : cartID
                    }).then((response) => {
                        this.cartItems = [];
                        var successMessage = this.$t('general.cart.success_checkout');
                        this.showAlert(successMessage);
                        setTimeout(function (){
                            location.href = '/cart/order-history';
                        },2000);
                    });
                }
            }.bind(this));
        }
    },
    computed : {
        cartTotal : function (){
            var cartTotal = 0;
            this.cartItems.filter(function (cartItem){
                cartTotal += (cartItem.product.price * cartItem.qty);
            });
            return cartTotal.toFixed(2);
        }
    }
}
</script>
