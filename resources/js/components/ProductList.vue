<template>
    <div class="container product-list">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center">Find your product and do "Add to cart" to purchase a lot once!</h3>
            </div>
        </div>
        <div class="row" v-for="category in categories" :key="category.id">
            <div class="col-lg-12">
                <p class="text-left">Category Name: {{category.name}}</p>
            </div>
            <div class="col-lg-3" v-for="product in category.products" :key="'P'+product.id">
                <div class="product-thumbnail">
                    <img :src="product.image" class="img-responsive" />
                    <h4>Name: {{product.name}}</h4>
                    <p>This product is available in the stock.</p>
                    <h3>Price: <span class="pull-right">Rs. {{product.price}}</span></h3>
                    <div class="product-actions">
                        <button class="btn btn-sm btn-primary" v-on:click="addToCart(product)">Add To Cart</button>
                        <a class="btn btn-sm btn-warning" :href="'/product/'+category.name+'/'+product.id">View Item</a>
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

            }
        },
        props : [
            'categories'
        ],
        methods:{
            addToCart : function (product){
                axios.post('/add-to-cart',{
                    product_id : product.id
                }).then((response) => {
                    alert(response);
                }).catch(() => {
                    alert('error');
                });
            }
        }
    }
</script>
