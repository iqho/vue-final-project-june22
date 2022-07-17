<template>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th style="width: 10%; text-align:center">#</th>
                    <th style="width: 60%">Name / Price / Quantity</th>
                    <th style="width: 20%; text-align:center">Total</th>
                    <th style="width: 10%; text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in cart" :key="index">
                    <td class="v-align text-center">{{ index + 1 }}</td>
                    <td class="p-0">
                        <div class="row g-0">
                            <div class="col-12 v-align px-2 py-1">{{ product.name }}</div>
                            <div class="col-12 border-top border-gray">
                                <div class="input-group v-align g-0">
                                    <span class="input-group-text bg-transparent border-0">${{ product.price }}</span>
                                    <span class="input-group-text bg-transparent border-0">x</span>
                                    <input type="number" min="1" :value="product.quantity"
                                    @change="updateQuantity(product.id, $event)" class="form-control border-0 g-0 p-1 shadow-none v-align" style="width:50px;"/>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="v-align text-center">${{ product.price * product.quantity }}</td>
                    <td class="v-align text-center">
                        <button class="btn btn-danger btn-sm" @click="removeItem(index)">X</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-end fs-5 px-2 py-3"><strong>Grand Total</strong></td>
                    <td colspan="2" class="text-start fs-5 px-2 py-3">
                        <strong>{{ "$" + totalPrice }}</strong>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-center py-2">
                        <button class="btn btn-primary" @click="goToCart()" data-bs-dismiss="offcanvas">Cart Page</button>
                        <button class="btn btn-success ms-1" @click="goToCheckout()" data-bs-dismiss="offcanvas">
                            Checkout Page
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>
<script>
export default {
    name: "NavbarCart",

    computed: {
        cartCount() {
            return this.$store.getters.storeCart.length;
        },

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

        goToCart() {
            this.$router.push("/cart");
        },

        goToCheckout() {
            this.$router.push("/checkout");
        },

        updateQuantity(id, event) {
            let quantity = Number(event.target.value);
            this.$store.dispatch("updateQuantity", { id, quantity });
        },
    },
};
</script>
