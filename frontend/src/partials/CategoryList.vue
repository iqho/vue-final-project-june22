<template>
    <div>
        <div class="list-group">
          <div class="list-group-item d-flex justify-content-between align-items-center">
            <h5 class="py-1 g-0">Categories</h5>
          </div>

          <div v-for="(category, index) in categories" :key="index">
            <h6 class="py-1 g-0 list-group-item d-flex justify-content-between align-items-center border-top-0" 
            v-if="category.products.length > 0 ">
              <router-link :to="{name: 'CategoryWiseProducts', params: {slug: category.slug}}" class="router-link p-2">
                <i class="fa-solid fa-angles-right me-1"></i> {{ category.name }} ( {{ category.products.length }} )
              </router-link>
            </h6>
          </div>
        </div>

    </div>
</template>

<script>
  export default {
    name: 'CategoryList',

    computed: {
        categories() {
            return this.$store.getters.categories;
        },
    },      
  }
</script>
