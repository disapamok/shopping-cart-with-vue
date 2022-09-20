<template>
    <div class="container product-list">
        <div class="row">
            <div class="col-lg-9">
                <h3 class="text-left">{{$t('general.products_title')}}</h3>
            </div>
            <div class="col-lg-3">
                <a href="/cart" class="btn btn-danger float-right">{{$t('general.view_cart')}} - ({{cartItems.length}} Items)</a>
            </div>
        </div>
        <div class="row" v-for="category in categories" :key="category.id">
            <div class="col-lg-12">
                <p class="text-left">{{$t('general.category_name')}}: {{category.name}}</p>
            </div>
            <div class="col-lg-3" v-for="product in category.products" :key="'P'+product.id">
                <div class="product-thumbnail">
                    <img :src="product.image" class="img-responsive" />
                    <h4>{{$t('general.name')}}: {{product.name}}</h4>
                    <p>{{$t('general.stock_available')}}</p>
                    <h3>{{ $t('general.price') }}: <span class="pull-right">{{$t('general.rupees')}}. {{product.price}}</span></h3>
                    <div class="product-actions">
                        <button class="btn btn-sm btn-primary" v-on:click="addToCart(product,$event)">{{$t('general.add_to_cart')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data (){
            return {
                cartItems : [],
            }
        },
        props : [
            'categories','cart'
        ],
        methods:{
            addToCart : function (product,event){
                axios.post('/cart/add-to-cart',{
                    product_id : product.id
                }).then((response) => {
                    if(response.data.data.created){
                        this.cartItems.push(product);
                    }
                    this.showAlert(response.data.message);

                    var btnTxt = event.target.innerHTML;
                    event.target.innerHTML = 'Addded';
                    setTimeout(function (){
                        event.target.innerHTML = btnTxt;
                    },1500);
                }).catch(() => {
                    this.showAlert('There was an error while adding item to the cart.');
                });
            }
        },
        mounted(){
            this.cartItems = this.cart.items;
        }
    }
</script>
