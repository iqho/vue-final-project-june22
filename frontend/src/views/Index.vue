<template>
  <div class="row g-0">
    <div class="col-sm-12 col-md-3">
      <CategoryList />
    </div>
    <div class="col-sm-12 col-md-9">
      <div class="row g-0 mx-3 px-2 border border-gray">
        <div class="col-12">
          <div class="row p-2 mb-2">
            <div class="col-12 text-center border-bottom border-gray">
              <h3>Latest Products</h3>
            </div>
            <div class="row g-0 mt-2">
              <div class="col-7 text-end pe-2" style="padding-top: 7px">
                <label for="password" class="form-label">Filter By</label>
              </div>
              <div class="col-2 pe-1">
                <select
                  v-model="filterName"
                  class="form-select shadow-none w-100"
                >
                  <option value="1">Date</option>
                  <option value="2">Price</option>
                  <option value="3">Name</option>
                </select>
              </div>
              <div class="col-3">
                <select
                  v-model="filterByAD"
                  class="form-select shadow-none w-100"
                >
                  <option value="1">Order By DESC</option>
                  <option value="2">Order By ASC</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row row-cols-1 row-cols-md-4 g-4">
            <div v-for="(product, index) in limitedProductsList" :key="index">
              <div class="card h-100">
                <router-link
                  :to="{ name: 'ProductDetails', params: { slug: product.slug } }"
                  class="p-2"
                >
                  <img
                    :src="`http://127.0.0.1:8000/product-images/${product.image}`"
                    class="card-img-top"
                    :alt="product.name"
                    style="height: 130px"
                  />
                </router-link>
                <div class="card-body g-0">
                  <h6 class="card-title p-2 text-danger">
                    <router-link
                      :to="{
                        name: 'ProductDetails',
                        params: { slug: product.slug },
                      }"
                      class="router-link"
                      >{{ product.name.substring(0, 35) }}</router-link
                    >
                  </h6>
                </div>
                <div class="card-footer text-center fs-5 p-1">
                  <small class="text-primary float-start ms-2 pt-1">
                    ${{ product.prices[0].amount.toFixed(2) }}</small
                  >
                  <button
                    class="btn btn-outline-danger btn-sm float-end shadow-none"
                    v-on:click="addToCart(product.id)"
                  >
                    <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-0 mt-3">
            <div class="col-12 text-center py-3">
              <router-link to="/products" class="btn btn-outline-success"
                >More Products <i class="fa-solid fa-angles-right"></i
              ></router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CategoryList from "../partials/CategoryList.vue";

export default {
  data() {
    return {
      filterName: "1",
      filterByAD: "1",
      productsLimit: 12,
    };
  },

  components: {
    CategoryList,
  },

  computed: {
    filterProducts() {
      return this.filterProductsByPrice(this.$store.getters.products);
    },

    limitedProductsList() {
      return this.filterProducts.slice(0, this.productsLimit);
    },
  },

  methods: {
    addToCart(id) {
      this.$store.dispatch("addItem", id);
    },

    filterProductsByPrice: function (products) {
      const filterName = this.filterName;
      const filterByAD = this.filterByAD;
      return products.sort((a, b) => {
        if (filterName === "1" && filterByAD === "1") {
          return b.id - a.id;
        } else if (filterName === "1" && filterByAD === "2") {
          return a.id - b.id;
        } else if (filterName === "2" && filterByAD === "1") {
          return b.prices[0].amount - a.prices[0].amount;
        } else if (filterName === "2" && filterByAD === "2") {
          return a.prices[0].amount - b.prices[0].amount;
        } else if (filterName === "3" && filterByAD === "1") {
          return a.name.toLowerCase() < b.name.toLowerCase() ? 1 : -1;
        } else if (filterName === "3" && filterByAD === "2") {
          return a.name.toLowerCase() > b.name.toLowerCase() ? 1 : -1;
        }
      });
    },
  },
};
</script>

<style scoped>
.router-link {
  text-decoration: none;
}
</style>
