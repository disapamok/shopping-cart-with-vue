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
                    <h6>Rs. {{item.product.price}}</h6>
                    <input type="number" :value="item.qty" disabled/>
                    <button class="btn btn-sm btn-danger" v-on:click="remove(item)">Remove</button>
                </div>
            </div>
            <div class="col-lg-12" v-if="cartItems.length == 0">
                <div class="alert alert-warning text-center">Your cart is empty. Add items from the product page.</div>
            </div>
            <a href="/" class="btn btn-sm btn-primary center">Back to products</a>
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
                    console.log(this.cartItems);
                    axios.delete('/cart/remove-item/'+item.id).then((response) => {
                        this.cartItems = this.cartItems.filter(function (ArItem){
                            return ArItem.id !== item.id;
                        });
                        this.showAlert(response.data.message);
                    }).catch((error) => {});
                }
            }.bind(this));

        }
    }
}
</script>
