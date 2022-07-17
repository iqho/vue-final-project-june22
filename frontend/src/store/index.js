import { createStore } from "vuex";

import axios from "axios";

const apiApplicationPath = "http://127.0.0.1:8000/api";

export default createStore({
  state: {
    products: [],
    categories: [],
    storeCart: JSON.parse(localStorage.getItem("cart")) || [],
    userToken: JSON.parse(localStorage.getItem("userToken")) || "",
    userData: JSON.parse(localStorage.getItem("userData")) || [],
    loginError: "",
    registerErrors: "",
    userName:'',
    userNumber:'',
    userAddress:''
  },

  getters: {
    getLoginError: (state) => {
      return state.loginError;
    },

    getRegisterErrors: (state) => {
      return state.registerErrors;
    },

    isLoggedIn: (state) => {
      if (state.userToken) {
        return true;
      } else {
        return false;
      }
    },

    getUserName:(state) => {
      return state.userName
    },

    getUserNumber:(state) => {
      return state.userNumber
    },

    getUserAddress:(state) => {
      return state.userAddress
    },

    getUserData: (state) => {
      //console.log(state.userData)
      return state.userData;
    },

    products: (state) => {
      return state.products;
    },

    categories: (state) => {
      return state.categories;
    },

    storeCart: (state) => {
      return state.storeCart;
    },

    cartCount: (state) => {
      return state.storeCart.length;
    },

    totalAmount: (state) => {
      state.total = state.storeCart.reduce((total, item) => {
        return total + item.price * item.quantity;
      }, 0);

      return state.total.toFixed(2);
    },
  },

  mutations: {
    SET_PRODUCTS(state, products) {
      state.products = products;
    },

    SET_CATEGORIES(state, categories) {
      state.categories = categories;
    },

    SET_LOGIN_ERROR(state, loginError) {
      state.loginError = loginError;
    },

    SET_REGISTER_ERRORS(state, registerErrors) {
      state.registerErrors = registerErrors;
    },

    SET_USER_NAME(state, userName) {
      state.userName = userName;
    },

    SET_USER_NUMBER(state, userNumber) {
      state.userNumber = userNumber;
    },

    SET_USER_ADDRESS(state, userAddress) {
      state.userAddress = userAddress;
    },

    SET_USER_DATA(state, userData) {
      state.userData = userData;
    },

    SET_USER_TOKEN(state, token) {
      state.userToken = token;
    },

    ADD_ITEM(state, id) {
      const record = state.storeCart.find((p) => p.id === id);
      const item = state.products.find((p) => p.id === id);

      if (!record) {
        state.storeCart.push({
          id: id,
          name: item.name,
          price: item.prices[0].amount,
          image: item.image,
          quantity: 1,
        });

        alert('Product Added to Cart Successfully');
      } else {
        record.quantity++;
        alert('Product already Added to Your Cart ! Quantity Updated.');
      }
    },

    REMOVE_ITEM(state, index) {
      state.storeCart.splice(index, 1);
    },

    UPDATE_QUANTITY(state, item) {
      const record = state.storeCart.find((p) => p.id === item.id);
      if (record) {
        record.quantity = item.quantity;
      }
    },

    CLEAR_CART(state) {
      localStorage.removeItem("cart");
      state.storeCart = [];
    },

    LOGOUT(state) {
      localStorage.removeItem("userToken");
      state.userToken = "";
      state.userData = [];
      alert("Logout Successfully");
    },
  },

  actions: {
    async fetchProducts({ commit }) {
      try {
        const response = await axios.get(apiApplicationPath + "/api-products");
        commit("SET_PRODUCTS", response.data.products);
      } catch (error) {
        // console.log(error)
      }
    },

    async fetchCategories({ commit }) {
      try {
        const response = await axios.get(
          apiApplicationPath + "/api-categories"
        );
        commit("SET_CATEGORIES", response.data.categories);
      } catch (error) {
        // console.log(error)
      }
    },

    login({ commit }, data) {
      axios
        .post(apiApplicationPath + "/login", data)
        .then((response) => {
          if (response.data.isSuccessStatus === false) {
            commit("SET_LOGIN_ERROR", response.data.errors);
            //console.log(response.data.errors);
          } else {
            localStorage.setItem(
              "userToken",
              JSON.stringify(response.data.token)
            );
            localStorage.setItem(
              "userData",
              JSON.stringify(response.data.user)
            );
            commit("SET_USER_TOKEN", JSON.stringify(response.data.token));
            commit("SET_USER_DATA", JSON.stringify(response.data.user));
            commit("SET_USER_NAME", response.data.user.name);
            commit("SET_USER_NUMBER", response.data.user.contact_number);
            commit("SET_USER_ADDRESS", response.data.user.parmanent_address);
            commit("SET_LOGIN_ERROR", '');
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    register({ commit }, data) {
      axios
        .post(apiApplicationPath + "/register", data)
        .then((response) => {
          if (response.data.isSuccessStatus === false) {
            commit("SET_REGISTER_ERRORS", response.data.errors);
           // console.log(response.data.errors);
          } else {
            localStorage.setItem(
              "userToken",
              JSON.stringify(response.data.token)
            );
            localStorage.setItem(
              "userData",
              JSON.stringify(response.data.user)
            );
            commit("SET_USER_TOKEN", JSON.stringify(response.data.token));
            commit("SET_USER_DATA", JSON.stringify(response.data.user));
            commit("SET_USER_NAME", response.data.user.name);
            commit("SET_USER_NUMBER", response.data.user.contact_number);
            commit("SET_USER_ADDRESS", response.data.user.parmanent_address);
            commit("SET_REGISTER_ERRORS", '');
            //alert("Register Successfully");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    addItem(context, id) {
      context.commit("ADD_ITEM", id);
      localStorage.setItem("cart", JSON.stringify(context.state.storeCart));
    },

    removeItem(context, index) {
      context.commit("REMOVE_ITEM", index);
      localStorage.setItem("cart", JSON.stringify(context.state.storeCart));
    },

    updateQuantity(context, item) {
      context.commit("UPDATE_QUANTITY", item);
      localStorage.setItem("cart", JSON.stringify(context.state.storeCart));
    },

    clearCart(context) {
      context.commit("CLEAR_CART");
      localStorage.setItem("cart", JSON.stringify(context.state.storeCart));
    },

    logout(context) {
      context.commit("LOGOUT");
    },
  },
});
