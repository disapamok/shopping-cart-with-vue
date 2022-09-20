<template>
    <div class="container admin-products">
        <div class="row">
            <div class="col-lg-12 heading">
                <h4>{{ $t('general.admin.products') }}</h4>
                <p>{{ $t('general.admin.product_tagline') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addProduct">{{ $t('general.admin.add_product') }}</button>
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
                        <th>{{ $t('general.admin.name' )}}</th>
                        <th>{{ $t('general.admin.price' )}}</th>
                        <th>{{ $t('general.admin.description' )}}</th>
                        <th>{{ $t('general.admin.image' )}}</th>
                        <th class="text-right">{{ $t('general.admin.actions' )}}</th>
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
                <p class="text-right">{{ $t('general.admin.result_count',{ count: filteredProducts.length }) }}</p>
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
