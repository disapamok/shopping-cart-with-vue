<template>
    <div class="container the-cart">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center">Your shopping cart</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 cart-item" v-for="item in cart.items" :key="item.id">
                <div class="flexbox">
                    <img :src="item.product.image" width="64"/>
                    <div class="prod-name">
                        <h4>{{item.product.name}}</h4>
                        <p>{{item.product.category.name}}</p>
                    </div>
                    <input type="number" :value="item.qty"/>
                    <button class="btn btn-sm btn-danger">Remove</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    data(){
        return{

        }
    },
    props: [
        'cart'
    ],
    mounted(){
        console.log(this.cart);
    }
}
</script>
