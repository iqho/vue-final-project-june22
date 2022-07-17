import {createRouter, createWebHistory} from 'vue-router'

const routes = [
  {
    path: '/:pathMatch(.*)*',
    name: "404",
    component: () => import("../pages/404.vue"),
  },

  {
    path: "/",
    name: "Home",
    component: () => import("../views/Index.vue"),
  },

  {
    path: "/products",
    name: "Products",
    component: () => import("../views/products/Index.vue"),
  },

  {
    path: "/category/:slug",
    name: "CategoryWiseProducts",
    component: () => import("../views/products/CategoryWiseProducts.vue"),
    props: true,
  },

  {
    path: "/product/:slug",
    name: "ProductDetails",
    component: () => import("../views/products/Details.vue"),
    props: true,
    // beforeEnter(to, from, next) {
    //   const exists = this.$store.getters.products.filter((product) => product.slug == this.slug);
    // }
  },

  {
    path: "/cart",
    name: "CartPage",
    component: () => import("../pages/CartPage.vue"),
  },

  {
    path: "/checkout",
    name: "Checkout",
    component: () => import('../pages/Checkout.vue'),
  },

  {
    path: "/login",
    name: "Login",
    component: () => import("../pages/auth/Login.vue"),
  },

  {
    path: "/register",
    name: "Register",
    component: () => import("../pages/auth/Register.vue"),
  },
];

const router = createRouter({ history: createWebHistory(), routes });

export default router;
