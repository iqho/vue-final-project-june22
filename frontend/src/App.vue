<template>
  <div class="row g-0">
    <div class="col-12">
      <Header></Header>
    </div>
    <div class="col-12 ps-3 pe-2 py-2">
      <router-view></router-view>
    </div>
    <div class="col-12">
      <Footer></Footer>
    </div>
    <a @click="scrollToTop()" href="#" class="btn btn-danger my-btn shadow-none"><i class="fa-solid fa-angles-up fa-lg"></i></a>
  </div>
</template>

<script>
import Header from "./partials/Header.vue";
import Footer from "./partials/Footer.vue";
export default {
  name: "App",
  components: {
    Header, Footer
  },

  methods:{
    scrollToTop() {
      window.scrollTo(0,0);
    }
  }
};
</script>

<style scoped>
    .my-btn {
      display: block;
      position: fixed;
      bottom: 20px;
      right: 50px;
      z-index: 99;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 5px;
      border-radius: 8px;
      font-size: 18px;
      width:60px;
    }
    .my-btn:hover{
      background-color: #1266F1;
    }
</style>
