<template>
    <div class="container order-history">
        <div class="col-lg-12" v-if="orders.length > 0">
            <div class="alert alert-success">
                {{ $t('general.oh.greet') }}
            </div>
            <h4>{{ $t('general.oh.title') }}:</h4>
        </div>
        <div class="col-lg-12" v-for="order in orders" :key="'ORDR'+order.id">
            <div class="card">
                <div class="card-body">
                    <div class="past-order">
                        <table class="order-meta">
                            <tr>
                                <td>{{ $t('general.oh.order_number') }}</td>
                                <td>{{ $t('general.oh.order_date') }}</td>
                                <td>{{ $t('general.gross_amount') }}</td>
                                <td>{{ $t('general.oh.payment_method') }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="badge badge-primary">
                                        {{order.order_number}}
                                    </span>
                                </td>
                                <td>{{order.created_date}}</td>
                                <td>{{order.gross_amount.toFixed(2)}}</td>
                                <td>Default</td>
                            </tr>
                        </table>
                    </div>
                    <div class="order-items">
                        <table class="table table-hover">
                            <tr>
                                <th>Product</th>
                                <th class="text-right">{{ $t('general.cart.quantity') }}</th>
                                <th class="text-right">{{ $t('general.price') }}</th>
                            </tr>
                            <tr v-for="item in order.items" :key="item.id">
                                <td>{{item.product.name}}</td>
                                <td class="text-right">{{item.qty}}</td>
                                <td class="text-right">{{item.sold_price}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12" v-if="orders.length == 0">
            <div class="alert alert-warning">
                {{ $t('general.oh.no_history') }}
            </div>
        </div>
        <a href="/" class="btn btn-success btn-sm center">{{ $t('general.oh.browse_products') }}</a>
    </div>
</template>

<script>

export default ({
    data() {
        return {

        }
    },
    props : ['orders'],
    mounted(){
        console.log(this.orders);
    }
})
</script>
