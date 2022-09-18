<template>
    <div class="modal" tabindex="-1" role="dialog" id="addProduct">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
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
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
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
</template>

<script>
export default {
    name: 'CreateProduct',
    data() {
        return {
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
    props : ['categories'],
    methods : {
        createProduct : function (){
            axios.post('/products/product',this.addProduct).then((response) => {
                this.showAlert(response.data.message);
                $('#addProduct').modal('hide');
                this.$emit('productAdded',response.data.data.theProduct);
            }).catch((error) => {
                this.addProductErrors = {
                    name: null,category: null,price: null,imageURL: null,description: null
                }
                this.addProductErrors = error.response.data.errors;
            });
        }
    },
    mounted (){
        this.addProduct.category = this.categories[0].id;
    }
};
</script>
