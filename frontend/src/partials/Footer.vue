<template>
    <div class="container border-top border-gray mt-3">
        <div class="row g-0 border-bottom border-gray pb-1" style="background-color: #eee">
            <span class="text-center py-3">All Right Reserve @ Win Win SP</span>
        </div>
    </div>
</template>
<script>

import Navbar from '../partials/Navbar.vue';

export default {
    name: 'Header',
    components: {
        Navbar
    },

    computed: {
        cartCount() {
            return this.$store.getters.storeCart.length;
        }
    }
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

    select, input {
        border: none;
        outline: none;
    }
    
</style>>



