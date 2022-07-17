<template>
    <div class="g-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-white container border-top border-bottom border-gray" :class="scrollNav ? 'fixed-top' : ''">
            <div class="container-fluid px-2">

                <!-- Navigation Bar -->
                <a class="navbar-toggler ms-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </a>

                <!-- Logo on Mobile Navigation -->
                <a class="navbar-brand d-lg-none mx-auto" href="/">
                    <img src="https://winwinsp.com/site/images/logo.png" alt="logo" width="180" height="30" />
                </a>

                <!-- Search Button on Mobile Navigation -->
                <a class="d-sm-block d-md-block d-lg-none"
                    data-bs-toggle="offcanvas"
                    href="#offcanvasSearchBar">
                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                </a>

                <!-- Cart Button on Mobile Navigation Bar -->
                <a class="position-relative ms-3 me-2 d-sm-block d-md-block d-lg-none"
                    id="dropdownMenuClickableOutside" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCartPanel">
                    <i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ cartCount }}
                    </span>
                </a>

                <!-- OffCanvas Navigation Panel -->
                <div class="offcanvas offcanvas-start g-0 text-center" id="offcanvasNavbar">

                    <!-- OffCanvas Header for Logo and Close Button on Mobile Navigation -->
                    <div class="offcanvas-header border-bottom border-gray">
                        <h5 class="offcanvas-title mx-auto" id="offcanvasCartPanelLabel">
                           <img src="https://winwinsp.com/site/images/logo.png" alt="logo" width="180" height="30" />
                        </h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>

                    <!-- Main Navigation Bar -->
                    <ul class="navbar-nav mx-auto py-1" style="min-width:300px">

                        <!-- Logo on Scrolling Page at Navigation Bar -->
                        <li>
                            <a class="navbar-brand ms-5" href="/" :class="scrollNav ? 'd-none d-lg-block' : 'd-none'">
                            <img src="https://winwinsp.com/site/images/logo.png" alt="logo" width="180" height="30" />
                            </a>
                        </li>
                        
                        <li class="nav-item" data-bs-dismiss="offcanvas">
                            <router-link to="/" class="nav-link border-right" active-class="active">Home
                            </router-link>
                        </li>

                        <li class="nav-item" data-bs-dismiss="offcanvas">
                            <router-link to="/products" class="nav-link border-right" active-class="active">
                                Products</router-link>
                        </li>

                        <li class="nav-item" data-bs-dismiss="offcanvas">
                            <router-link to="/cart" class="nav-link border-right" active-class="active">Cart
                            </router-link>
                        </li>

                        <li class="nav-item" data-bs-dismiss="offcanvas">
                            <router-link to="/checkout" class="nav-link" active-class="active">
                                Checkout
                            </router-link>
                        </li>

                        <!-- Search Panel Button on Scroll Page at Navigation Bar -->
                        <li class="align-self-center ms-5 ps-3 d-none d-lg-block">
                            <a class="position-relative mx-auto"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearchBar"
                            aria-expanded="false" :style="scrollNav ? 'display: block' : 'display: none'">
                                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                            </a>
                        </li>

                        <!-- Cart Button on Scroll Page at Navigation Bar -->
                        <li class="align-self-center ps-3 d-none d-lg-block">
                            <a class="position-relative mx-auto" id="dropdownMenuClickableOutside"
                            data-bs-toggle="offcanvas" data-bs-auto-close="outside" href="#offcanvasCartPanel"
                            aria-expanded="false" :style="scrollNav ? 'display: block' : 'display: none'">
                                <i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ cartCount }}
                                </span>
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>

        <!-- offCanvas Cart Panel -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCartPanel"
            aria-labelledby="offcanvasCartPanelLabel" style="width:100%; max-width:500px">
            <div class="offcanvas-header border-bottom border-gray">
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
                <h5 class="offcanvas-title mx-auto" id="offcanvasCartPanelLabel">
                    Cart Item ( {{ cartCount }} )
                </h5>
            </div>
            <div class="offcanvas-body">
                <NavbarCart />
            </div>
        </div>

        <!-- offCanvas Search Bar -->
        <div class="offcanvas offcanvas-top bg-transparent" id="offcanvasSearchBar" style="height:70px; background-color:none">
            <div class="offcanvas-body g-0 bg-transparent">
                <div class="container bg-white py-3">
                    <div class="input-group d-flex align-items-center px-2">
                        <button type="button" class="btn-close text-reset me-2" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                        <input type="text" v-model="search" placeholder="Search Product" class="form-control shadow-none px-3 py-2">
                        <button name="search" class="btn btn-primary py-2">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="container position-absolute mt-2" style="z-index:9999;">
                        <div v-if="limitedProductsList.length > 0" class="list-group">
                            <router-link v-for="(product, index) in limitedProductsList" :key="index" 
                            :to="`/product/${product.id}`" :id="product.id" 
                            class="list-group-item list-group-item-action py-1 px-2 text-primary" @click="resetInput">
                                {{ product.title }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import NavbarCart from "../components/NavbarCart.vue";

export default {
    name: "Navbar",
    data() {
        return {
            scrollNav: false,
            search: '',
            category:'',
            searchResultsLimit: 10
        }
    },

    components: {
        NavbarCart,
    },

    computed: {
        cartCount() {
            return this.$store.getters.storeCart.length;
        },

        categories() {
            return this.$store.getters.categories;
        },

        filterProducts(){
            if (this.search) {
            return this.filterProductsByName(this.filterProductsByCategory(this.$store.getters.products))
            } else {
                return '';
            }
        },

        limitedProductsList(){
            return this.filterProducts.slice(0, this.searchResultsLimit);
        }

    },

    methods: {
        handleSCroll(event) {
            if (window.scrollY > 100) {
                return this.scrollNav = true;
            } else if (window.scrollY < 100) {
                return this.scrollNav = false;
            }
        },


        filterProductsByName: function(products) {
            return products.filter(product => { return product.title.toLowerCase().includes(this.search.toLowerCase())
            })
        },
        
        filterProductsByCategory: function(products){
            return products.filter(product => !product.category.indexOf(this.category))
        },

        resetInput(){
            this.search = ''
        },

    },

    created() {
        window.addEventListener("scroll", this.handleSCroll);

    },
    destroyed() {
        window.removeEventListener("scroll", this.handleSCroll);
    },
};

</script>

<style lang="css" scoped>
.active {
    background-color: #ccc;
    border-radius: 5px 5px 0 0;
}

@media only screen and (min-width : 992px) {
    .border-right{
        border-right: 1px solid #ccc;
    }
}

</style>
