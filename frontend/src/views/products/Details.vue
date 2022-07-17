<template>
  <div class="row g-0">
    <div class="col-3">
      <CategoryList />
    </div>
    <div class="col-sm-12 col-md-9 ps-3 pe-2">
            <div class="row g-0">
                <div class="col-12 text-end p-2">
                    <a @click="$router.go(-1)" class="btn btn-success">Back</a>
                </div>
            </div>
            <div v-for="(product, index) in filterProducts" :key="index">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-0">
                            <div class="col-4">
                                <img :src="'http://127.0.0.1:8000/product-images/' + product.image" class="card-img-top"
                                    :alt="product.name" style="height:130px">
                            </div>
                            <div class="col-8 px-3 py-1">
                                <h3 class="card-title border-bottom pb-2">{{ product.name }}</h3>

                                <div class="row g-0">
                                    <div class="col-12">
                                        <div class="text-black fs-5">Category: <strong class="text-primary">
                                                <router-link
                                                    :to="{ name: 'CategoryWiseProducts', params: { slug: product.category.slug } }"
                                                    class="router-link p-2">
                                                    {{ product.category.name }}
                                                </router-link>
                                            </strong></div>
                                        <div class="row g-0">
                                            <div class="col-sm-12 col-md-6 fs-4">
                                                Price: <strong class="text-primary">${{ product.prices[0].amount.toFixed(2)
                                                }}</strong>
                                            </div>
                                            <div class="col-sm-12 col-md-6 text-end">
                                                <button class="btn btn-outline-danger mt-1 shadow-none"
                                                    v-on:click="addToCart(product.id)">
                                                    Add to Cart <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-0">
                            <div class="col-12 border-top border-gray-500 mt-4">
                                <p class="card-text fs-6 py-2" style="text-align: justify">{{ product.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
import CategoryList from "../../partials/CategoryList.vue";

export default {
  name: "CategoryWiseProducts",

  props: {
    slug: {
      type: String,
      required: true,
    },
  },

  components: {
    CategoryList,
  },

  computed: {

    filterProducts() {
      return this.filterProductsBySlug(this.$store.getters.products);
    },
  },

  methods: {
    addToCart(id) {
      this.$store.dispatch("addItem", id);
    },

    filterProductsBySlug: function (products) {
      return products.filter((product) => product.slug == this.slug);
    },

  },
};
</script>

<style scoped>
.router-link {
  text-decoration: none;
}
</style>
