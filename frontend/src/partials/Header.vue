<template>
    <div class="container py-1">
        <div class="row g-0 border-bottom border-gray pb-1">
            <nav class="navbar navbar-expand g-0">
                <div class="container-fluid g-0 px-1 py-2">
                    <span class="ps-2 d-none d-lg-block">Welcome to Win Win SP | Largest Bangladeshi E-Commerce</span>

                        <ul v-if="isLoggedIn" class="navbar-nav ms-auto g-0">
                            <li class="nav-item">
                                <a href="#" class="nav-link">{{ userName ? userName : this.$store.getters.getUserName }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" @click="logout" class="nav-link">Logout</a>
                            </li>
                        </ul>
                        <ul v-else class="navbar-nav ms-auto g-0">
                            <li class="nav-item">
                                <router-link to="/login" class="nav-link">Login</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/register" class="nav-link">Register</router-link>
                            </li>
                        </ul>

                </div>
            </nav>
        </div>
        <div class="container d-none d-lg-block">
            <div class="row g-0 my-4 ps-2">
                <div class="col-4 text-center pb-1">
                    <a class="navbar-brand" href="/">
                        <img src="https://winwinsp.com/site/images/logo.png" alt="logo" width="250" height="50">
                    </a>
                </div>
                <div class="col-6 d-flex align-items-center">
                    <SearchComponent/>
                </div>
                <div class="col-2 d-flex align-items-center">
                    <a class="position-relative mx-auto" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCartPanel">
                        <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ cartCount }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row g-0"><Navbar/></div>
    </div>
</template>
<script>

import Navbar from '../partials/Navbar.vue';
import SearchComponent from '../components/SearchComponent.vue';

export default {
    name: 'Header',
    components: {
        Navbar, SearchComponent
    },

    computed: {
        cartCount() {
            return this.$store.getters.storeCart.length;
        },

        isLoggedIn() {
            return this.$store.getters.isLoggedIn;
        },

        userName(){
            return this.$store.getters.getUserData.name;
        }

    },

    
    methods: {
        logout() {
            this.$store.dispatch('logout')
        }
    },

};

</script>
<style lang="css" scoped>

    .navbar ul li a{
        color: #000;
        padding: 0px 10px !important;
    }
    .navbar ul li a:hover{
        color: rgb(3, 0, 206);
    }
    .navbar ul li {
        padding: 0px !important;
        border-right:1px solid #ccc
    }
    .navbar ul li:last-child {
        border-right:0px solid #ccc
    }    
</style>>



