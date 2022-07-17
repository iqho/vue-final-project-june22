<template>
  <div class="row g-0">
    <div class="col-3">
      <CategoryList />
    </div>
    <div class="col-9">
      <div class="row g-0 mx-3 px-2 border border-gray">
        <div class="col-12">
          <div class="row p-2 mb-2">
            <div class="col-12 text-center border-bottom border-gray pb-2">
              <strong class="fs-4"> Category: </strong><strong v-if="filterProducts.length > 0"
                class="fs-4 text-primary">{{ filterProducts[0].category.name }} (
                {{ filterProducts.length }} )</strong>
            </div>

            <div class="row g-0 mt-2">
              <div class="col-4 pe-2 text-end g-0" style="padding-top: 7px">
                <div class="input-group">
                  <select class="shadow-none m-0 p-1 ps-2" v-model="pageSize"
                    style="width:60px; border: 1px solid #ccc">
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                  </select>
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent border-0">Products Show Per Page</span>
                  </div>
                </div>
              </div>
              <div class="col-3 text-end pe-2" style="padding-top: 7px">
                <label for="password" class="form-label">Filter By</label>
              </div>
              <div class="col-2 pe-1">
                <select v-model="filterName" class="form-select shadow-none w-100">
                  <option value="1">Date</option>
                  <option value="2">Price</option>
                  <option value="3">Name</option>
                </select>
              </div>
              <div class="col-3">
                <select v-model="filterByAD" class="form-select shadow-none w-100">
                  <option value="1">Order By DESC</option>
                  <option value="2">Order By ASC</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row row-cols-1 row-cols-md-4 g-4">
            <div v-for="(product, index) in paginatedProducts" :key="index">
              <div class="card h-100">
                <router-link :to="{ name: 'ProductDetails', params: { slug: product.slug } }" class="p-2">
                  <img :src="
                    'http://127.0.0.1:8000/product-images/' + product.image
                  " class="card-img-top" :alt="product.name" style="height: 130px" />
                </router-link>
                <div class="card-body g-0">
                  <h6 class="card-title p-2 text-danger">
                    <router-link :to="{
                      name: 'ProductDetails',
                      params: { slug: product.slug },
                    }" class="router-link">{{ product.name.substring(0, 35) }}
                    </router-link>
                  </h6>
                </div>
                <div class="card-footer text-center fs-5 p-1">
                  <small class="text-primary float-start ms-2 pt-1">
                    ${{ product.prices[0].amount.toFixed(2) }}</small>
                  <button class="btn btn-outline-danger btn-sm float-end shadow-none"
                    v-on:click="addToCart(product.id)">
                    <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination Start -->
          <div class="row g-0 mt-4">
            <div class="col-12 py-2">
              <nav>
                <ul class="pagination justify-content-center">
                  <li class="page-item" v-bind:class="current === 1 ? 'disabled' : ''">
                    <a class="page-link shadow-none" style="cursor: pointer" @click="prev()">Previous</a>
                  </li>
                  <li class="page-item active" aria-current="page">
                    <a class="page-link">{{ current }}</a>
                  </li>
                  <li class="page-item disabled p-0">
                    <a class="page-link ps-1" aria-disabled="true">of {{ totalPage }}</a>
                  </li>
                  <li class="page-item" v-bind:class="current === totalPage ? 'disabled' : ''">
                    <a class="page-link shadow-none" style="cursor: pointer" @click="next()">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          <!-- Pagination Close -->
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

  data() {
    return {
      filterName: "1",
      filterByAD: "1",
      current: 1,
      pageSize: 10,
    };
  },

  components: {
    CategoryList,
  },

  computed: {
    indexStart() {
      return (this.current - 1) * this.pageSize;
    },

    indexEnd() {
      return this.indexStart + this.pageSize;
    },

    paginatedProducts() {
      return this.filterProducts.slice(this.indexStart, this.indexEnd);
    },

    totalPage() {
      const total = this.filterProducts.length;
      return Math.ceil(total / this.pageSize);
    },

    filterProducts() {
      return this.filterProductsByCategory(
        this.filterProductsByPrice(this.$store.getters.products)
      );
    },
  },

  methods: {
    addToCart(id) {
      this.$store.dispatch("addItem", id);
    },

    prev() {
      if (this.current === 1) return;
      this.current--;
    },

    next() {
      if (this.current === Number(this.totalPage)) return;
      this.current++;
    },

    filterProductsByCategory: function (products) {
      return products.filter((product) => product.category.slug == this.slug);
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
