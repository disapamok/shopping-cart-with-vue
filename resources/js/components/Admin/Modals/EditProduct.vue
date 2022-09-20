<template>
    <div class="modal" tabindex="-1" role="dialog" id="editProduct">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $t('general.product.edit_title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ $t('general.product.name') }}</label>
                        <input type="text" :placeholder="$t('general.product.name')" class="form-control" v-model="editProduct.product_name"/>
                        <p v-if="editProductErrors.product_name != null" class="text-danger">{{editProductErrors.product_name[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('general.product.category') }}</label>
                        <select class="form-control" v-model="editProduct.product_category">
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                        </select>
                        <p v-if="editProductErrors.product_category != null" class="text-danger">{{editProductErrors.product_category[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('general.product.price') }}</label>
                        <input type="text" :placeholder="$t('general.product.price')" class="form-control" v-model="editProduct.product_price"/>
                        <p v-if="editProductErrors.product_price != null" class="text-danger">{{editProductErrors.product_price[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('general.product.image') }}</label>
                        <input type="text" :placeholder="$t('general.product.image')" class="form-control" v-model="editProduct.product_image"/>
                        <p v-if="editProductErrors.product_image != null" class="text-danger">{{editProductErrors.product_image[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('general.product.description') }}</label>
                        <textarea type="text" :placeholder="$t('general.product.description')" class="form-control" rows="4" v-model="editProduct.product_description"></textarea>
                        <p v-if="editProductErrors.product_description != null" class="text-danger">{{editProductErrors.product_description[0]}}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="updateProduct()">{{ $t('general.product.do_update') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $t('general.product.close_action') }}</button>
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
                product_id: null,
                product_name: null,
                category: null,
                product_price: null,
                product_name: null,
                product_description: null
            },
            editProductErrors:{
                product_name: null,
                category: null,
                product_price: null,
                product_name: null,
                product_description: null
            },
        }
    },
    props : ['categories'],
    methods : {
        updateProduct : function (){
            var productId = this.editProduct.product_id;

            axios.put('/products/product/'+productId,this.editProduct).then((response) => {
                this.showAlert(response.data.message);
                $('#editProduct').modal('hide');
                this.$emit('productUpdated',response.data.data.theProduct);
            }).catch((error) => {
                this.editProductErrors = {
                    name: null,category: null,price: null,imageURL: null,description: null
                }
                this.editProductErrors = error.response.data.errors;
            });
        },
        openModal : function (product){
            this.editProduct.product_id = product.id;
            this.editProduct.product_name = product.name;
            this.editProduct.product_image = product.image;
            this.editProduct.product_price = product.price;
            this.editProduct.product_category = product.category_id;
            this.editProduct.product_description = product.description;
            $('#editProduct').modal('show');
        }
    },
    mounted (){
        this.editProduct.category = this.categories[0].id;
    }
};
</script>
