<template>
    <div class="modal" tabindex="-1" role="dialog" id="editProduct">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" placeholder="Product Name" class="form-control" v-model="editProduct.name"/>
                        <p v-if="editProductErrors.name != null" class="text-danger">{{editProductErrors.name[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" v-model="editProduct.category">
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                        </select>
                        <p v-if="editProductErrors.category != null" class="text-danger">{{editProductErrors.category[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>Product Price</label>
                        <input type="text" placeholder="Product Price" class="form-control" v-model="editProduct.price"/>
                        <p v-if="editProductErrors.price != null" class="text-danger">{{editProductErrors.price[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>Image URL</label>
                        <input type="text" placeholder="Product Price" class="form-control" v-model="editProduct.imageURL"/>
                        <p v-if="editProductErrors.imageURL != null" class="text-danger">{{editProductErrors.imageURL[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <textarea type="text" placeholder="Product Description" class="form-control" rows="4" v-model="editProduct.description"></textarea>
                        <p v-if="editProductErrors.description != null" class="text-danger">{{editProductErrors.description[0]}}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="updateProduct()">Add Product</button>
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
            editProduct: {
                name: null,
                category: null,
                price: null,
                imageURL: null,
                description: null
            },
            editProductErrors:{
                name: null,
                category: null,
                price: null,
                imageURL: null,
                description: null
            }
        }
    },
    props : ['categories','product'],
    methods : {
        updateProduct : function (){
            axios.post('/products/product',this.editProduct).then((response) => {
                this.showAlert(response.data.message);
                $('#editProduct').modal('hide');
                this.$emit('productAdded',this.editProduct);
            }).catch((error) => {
                this.editProductErrors = {
                    name: null,category: null,price: null,imageURL: null,description: null
                }
                this.editProductErrors = error.response.data.errors;
            });
        },
        openModal : function (product){
            this.editProduct = product;
            this.editProduct.category = product.category_id;
            this.editProduct.imageURL = product.image;
            $('#editProduct').modal('show');
        }
    },
    mounted (){
        this.editProduct.category = this.categories[0].id;
    }
};
</script>
