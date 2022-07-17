<template>

  <div class="row">
    <div v-if="isLoggedIn" class="col-12 text-center">
      <div class="card">
        <div class="card-header text-center pb-1">
          <h4>Welcome</h4>
        </div>
        <div class="card-body">
          <div class="row g-0">
            <div class="col-12">
              <h4>You are logged in</h4>
            </div>
          </div>
          <div class="row g-0">
            <div class="col-12">
              <button class="btn btn-primary" style="width: 180px; font-size: 20px" @click="onLogout">
                Logout
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>  

    <div v-else class="col-12 d-flex justify-content-center">
      <div class="card w-50">
        <div class="card-header text-center pb-1">
          <h4>Login</h4>
        </div>
        <div class="card-body">
          <div v-if="this.$store.getters.getLoginError" class="row g-0">
            <div class="col-12 alert alert-danger p-2" role="alert">
              {{ this.$store.getters.getLoginError }}
            </div>
          </div>
          <form @submit.prevent="onSubmitLoginForm">
            <div class="mb-3">
              <label for="email" class="form-label">Email address*</label>
              <input type="text" class="form-control" id="email" v-model="email" />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password*</label>
              <input type="password" class="form-control" id="password" v-model="password" />
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1" />
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 180px; font-size: 20px">
              Login
            </button>
          </form>
          <div class="row g-0 mt-2">
            <div class="col-12">
              New User ?
              <router-link to="/register" style="text-decoration: none">Register</router-link>
              here
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>  
  
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      email: "",
      password: "",
      errors: "",
    };
  },

  computed: {
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    }
  },

  methods: {
    onSubmitLoginForm() {
      if (this.email === "" || this.password === "") {
        alert("Email or Password can't be Empty");
        return;
      }

      const data = {
        email: this.email,
        password: this.password,
      };

      this.$store.dispatch("login", data);
    },

    onLogout() {
      this.$store.dispatch("logout");
    },
  },
};
</script>

<style></style>
