<template>
    <div class="container">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th style="width: 10%">#</th>
                    <th style="width: 30%; text-align:left">Name</th>
                    <th style="width: 20%">Image</th>
                    <th style="width: 10%">Price</th>
                    <th style="width: 10%">Quantity</th>
                    <th style="width: 10%">SubTotal</th>
                    <th style="width: 10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in cart" :key="index">
                    <td class="v-align">{{ index + 1 }}</td>
                    <td class="text-start v-align">{{ product.name }}</td>
                    <td>
                        <img :src="'http://127.0.0.1:8000/product-images/'+ product.image" height="40" width="50" />
                    </td>
                    <td class="v-align">{{ "$" + product.price.toFixed(2) }}</td>
                    <td>
                        <input type="number" class="form-control text-center" min="1" :value="product.quantity"
                            @change="updateQuantity(product.id, $event)" />
                    </td>
                    <td class="v-align">{{ "$" + (product.price * product.quantity).toFixed(2) }}</td>
                    <td>
                        <button class="btn btn-danger" @click="removeItem(index)">Remove</button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end fs-5">
                        <strong>Grand Total</strong>
                    </td>
                    <td colspan="2" class="text-start fs-5">
                        <strong>{{ "$" + totalPrice }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    name: "CartItem",

    data() {
        return {
            cartItem: this.$store.state.cartItem,
        };
    },

    computed: {
        totalPrice() {
            return this.$store.getters.totalAmount;
        },

        cart() {
            return this.$store.getters.storeCart.map((cartItems) => {
                return this.$store.getters.storeCart.find((itemForSale) => {
                    return cartItems.id === itemForSale.id;
                });
            });
        },
    },

    methods: {
        removeItem(index) {
            if(confirm("Do you really want to remove this product from cart ?")){
                this.$store.dispatch("removeItem", index);
            }
        },

        updateQuantity(id, event) {
            let quantity = Number(event.target.value);
            this.$store.dispatch("updateQuantity", { id, quantity });
        },
    },
};
</script>
