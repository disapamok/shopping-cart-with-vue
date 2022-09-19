<template>
    <div class="container the-cart">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center">Your shopping cart</h3>
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
                    <i>Quantity: {{item.qty}}</i>
                    <h6>Rs. {{item.product.price.toFixed(2)}}</h6>
                    <h6>Rs. {{(item.product.price * item.qty).toFixed(2)}}</h6>
                    <button class="btn btn-sm btn-danger" v-on:click="remove(item)">Remove</button>
                </div>
            </div>
            <div class="col-lg-12" v-if="cartItems.length == 0">
                <div class="alert alert-warning text-center">Your cart is empty. Add items from the product page.</div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-3 float-right">
                <table class="cart-total">
                    <tr>
                        <span>Total:</span>
                        <span class="float-right">{{cartTotal}}</span>
                    </tr>
                    <tr>
                        <span>Discounts:</span>
                        <span class="float-right">0 LKR</span>
                    </tr>
                    <tr>
                        <span>Total Payable:</span>
                        <span class="float-right">{{cartTotal}}</span>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button v-if="cartItems.length > 0" v-on:click="checkout()"  class="btn btn-danger center checkout-now">Checkout Now</button>
                <a href="/" class="btn btn-sm btn-primary center">Back to products</a>
            </div>
        </div>
    </div>
</template>

<script>
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
        this.cartItems = this.cart.items;
    },
    methods: {
        remove : function(item){
            this.ask(null,"This item will be removed from the cart!", function (action){
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
            this.ask(null,'This will perform the checkout. Are you sure you want to continue?',function (action){
                if(action.isConfirmed){
                    axios.put('cart/do-checkout',{
                        cart_id : cartID
                    }).then((response) => {
                        this.cartItems = [];
                        this.showAlert('Checkout process completed successfully.');
                        //location.href = '/cart/order-history';
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
