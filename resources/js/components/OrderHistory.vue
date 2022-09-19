<template>
    <div class="container order-history">
        <div class="col-lg-12" v-if="orders.length > 0">
            <div class="alert alert-success">
                Hello, You can find out your order history below.
            </div>
            <h4>Your order history:</h4>
        </div>
        <div class="col-lg-12" v-for="order in orders" :key="'ORDR'+order.id">
            <div class="card">
                <div class="card-body">
                    <div class="past-order">
                        <table class="order-meta">
                            <tr>
                                <td>Order Number</td>
                                <td>Order Date</td>
                                <td>Gross Amount</td>
                                <td>Payment Method</td>
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
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Price</th>
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
                You haven't placed orders yet. Start shopping now!
            </div>
        </div>
        <a href="/" class="btn btn-success btn-sm center">Browse Products</a>
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
