<template>
    <div class="modal" tabindex="-1" role="dialog" id="addProduct">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $t('general.product.add_title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ $t('general.product.name') }}</label>
                        <input type="text" :placeholder="$t('general.product.name')" class="form-control" v-model="addProduct.name"/>
                        <p v-if="addProductErrors.name != null" class="text-danger">{{addProductErrors.name[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('general.product.category') }}</label>
                        <select class="form-control" v-model="addProduct.category">
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                        </select>
                        <p v-if="addProductErrors.category != null" class="text-danger">{{addProductErrors.category[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('general.product.price') }}</label>
                        <input type="text" :placeholder="$t('general.product.price')" class="form-control" v-model="addProduct.price"/>
                        <p v-if="addProductErrors.price != null" class="text-danger">{{addProductErrors.price[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('general.product.image') }}</label>
                        <input type="text" :placeholder="$t('general.product.image')" class="form-control" v-model="addProduct.imageURL"/>
                        <p v-if="addProductErrors.imageURL != null" class="text-danger">{{addProductErrors.imageURL[0]}}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('general.product.description') }}</label>
                        <textarea type="text" :placeholder="$t('general.product.description')" class="form-control" rows="4" v-model="addProduct.description"></textarea>
                        <p v-if="addProductErrors.description != null" class="text-danger">{{addProductErrors.description[0]}}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="createProduct()">{{ $t('general.product.add_action') }}</button>
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
