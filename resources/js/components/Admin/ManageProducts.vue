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
                        <td>Rs. {{product.price.toFixed(2)}}</td>
                        <td>{{product.short_description}}</td>
                        <td><img :src="product.image" width="50"/></td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-primary" v-on:click="editProduct(product)">Edit</button>
                            <button class="btn btn-sm btn-danger" v-on:click="deleteProduct(product)">Delete</button>
                        </td>
                    </tr>
                </table>
                <p class="text-right">Showing {{filteredProducts.length}} result(s).</p>
            </div>
        </div>

        <addModal v-bind:categories="categories" v-on:productAdded="pushProduct"/>
        <editModal v-bind:categories="categories" ref="editProductsElement" v-on:productUpdated="updateProduct"/>
    </div>
</template>
<script>
import addModal from './Modals/CreateProduct.vue';
import editModal from './Modals/EditProduct.vue';

export default({
    name: 'ManageProducts',
    components:{
        'addModal' : addModal,
        'editModal' : editModal
    },
    data() {
        return {
            categoriesList : [],
            productsList : [],
            selectedCategory : null,
            filterReference : 0, // Reference to update the computed method.
        }
    },
    props : ['categories','products'],
    mounted(){
        this.categoriesList = this.categories;
        this.productsList = this.products;
        this.selectedCategory = this.categories[0].id;
    },
    computed:{
        filteredProducts : function (){
            this.filterReference;
            return this.productsList.filter(function (product){
                return product.category_id === this.selectedCategory;
            }.bind(this));
        }
    },
    methods:{
        pushProduct : function(prodData){
            this.productsList.push(prodData);
        },
        editProduct : function (product){
            this.$refs.editProductsElement.openModal(product);
        },
        updateProduct : function (prodData){
            var index;
            this.productsList.filter(function (iProduct,i){
                if(iProduct.id === prodData.id)
                    index = i;
            });
            this.productsList[index] = prodData;
            this.filterReference++; // Reference to update the computed method.
        },
        deleteProduct : function (product){
            this.ask(null,"This product will be deleted!", function (action){
                if(action.isConfirmed){
                    axios.delete('/products/product/'+product.id).then((response) => {
                        this.showAlert(response.data.message);
                        this.productsList = this.productsList.filter(function (iProduct){
                            return iProduct.id !== product.id;
                        });
                    }).catch((error) => {
                        this.showAlert('Error deleting the product.');
                    });
                }
            }.bind(this));
        }
    }
})
</script>
