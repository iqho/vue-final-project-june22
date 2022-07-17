<template>
    <div class="row g-0 position-relative w-100">
        <div class="col-12">
            <div class="input-group p-1" style="border-radius: 10px 0px 0px 10px">
                <input type="text" v-model="search" placeholder="Search Product" class="form-control shadow-none px-3 py-2" @focus="showResult = true" @blur="hideResult">
                <button name="search" class="btn btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div v-if="showResult" class="col-12 position-absolute mt-5 list-group" style="z-index:9999;">
            <router-link v-for="(product, index) in limitedProductsList" :key="index" 
            :to="{name: 'ProductDetails', params: {slug: product.slug}}" class="list-group-item list-group-item-action py-1 px-2 text-primary">
                {{ product.name }}
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SearchComponent',

    data(){
        return{
            search: '',
            searchResultsLimit: 10,
            showResult: false,
        }
    },

    mounted() {
          this.$store.dispatch("fetchCategories");
          this.$store.dispatch("fetchProducts");
    },

    computed: {

        limitedProductsList(){
            if (this.search) {
                this.showResult = true;
                return this.filterProductsByName(this.$store.getters.products).slice(0, this.searchResultsLimit);
            } 
            else {
                return '';
            }
        }
        
    },

    methods: {

        filterProductsByName: function(products) {
            return products.filter(product => { return product.name.toLowerCase().includes(this.search.toLowerCase())
            })
        },
        
        hideResult() {
            setTimeout(() => this.showResult = false, 150);
        }

    }
}
</script>

<style scoped>
    .border-bottom:last-child{
        border:none
    }

</style>