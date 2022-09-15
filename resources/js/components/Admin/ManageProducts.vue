<template>
    <div class="container admin-products">
        <div class="row">
            <div class="col-lg-12 heading">
                <h4>Products</h4>
                <p>These are the products that live on the website.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addProduct">Add Product</button>
            </div>
            <div class="ml-auto mr-3 category-selector">
                <div class="form-group">
                    <select class="form-control" v-model="selectedCategory">
                        <option v-for="category in categoriesList" :key="category.id" :value="category.id">{{category.name}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-dashed">
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    <tr v-for="product in filteredProducts" :key="'P'+product.id">
                        <td>{{product.name}}</td>
                        <td>{{product.price}}</td>
                        <td>{{product.short_description}}</td>
                        <td><img :src="product.image" width="50"/></td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                </table>
                <p class="text-right">Showing {{filteredProducts.length}} result(s).</p>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="addProduct">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" placeholder="Product Name" class="form-control" v-model="addProduct.name"/>
                            <p v-if="addProductErrors.name != null" class="text-danger">{{addProductErrors.name[0]}}</p>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" v-model="addProduct.category">
                                <option v-for="category in categoriesList" :key="category.id" :value="category.id">{{category.name}}</option>
                            </select>
                            <p v-if="addProductErrors.category != null" class="text-danger">{{addProductErrors.category[0]}}</p>
                        </div>
                        <div class="form-group">
                            <label>Product Price</label>
                            <input type="text" placeholder="Product Price" class="form-control" v-model="addProduct.price"/>
                            <p v-if="addProductErrors.price != null" class="text-danger">{{addProductErrors.price[0]}}</p>
                        </div>
                        <div class="form-group">
                            <label>Image URL</label>
                            <input type="text" placeholder="Product Price" class="form-control" v-model="addProduct.imageURL"/>
                            <p v-if="addProductErrors.imageURL != null" class="text-danger">{{addProductErrors.imageURL[0]}}</p>
                        </div>
                        <div class="form-group">
                            <label>Product Description</label>
                            <textarea type="text" placeholder="Product Description" class="form-control" rows="4" v-model="addProduct.description"></textarea>
                            <p v-if="addProductErrors.description != null" class="text-danger">{{addProductErrors.description[0]}}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="createProduct()">Add Product</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
export default({
    data() {
        return {
            categoriesList : [],
            productsList : [],
            selectedCategory : null,

            addProduct: {
                name: null,
                category: null,
                price: null,
                imageURL: null,
                description: null
            },
            addProductErrors:{
                name: null,
                category: null,
                price: null,
                imageURL: null,
                description: null
            }
        }
    },
    props : ['categories','products'],
    mounted(){
        this.categoriesList = this.categories;
        this.productsList = this.products;
        this.selectedCategory = this.categories[0].id;
        this.addProduct.category = this.categories[0].id;
    },
    computed:{
        filteredProducts : function (){
            return this.products.filter(function (product){
                return product.category_id === this.selectedCategory;
            }.bind(this));
        }
    },
    methods:{
        createProduct : function (){
            axios.post('/products/product',this.addProduct).then((response) => {

            }).catch((error) => {
                this.addProductErrors = {
                    name: null,
                    category: null,
                    price: null,
                    imageURL: null,
                    description: null
                }
                this.addProductErrors = error.response.data.errors;
            });
        }
    }
})
</script>
