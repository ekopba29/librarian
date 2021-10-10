<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Menu</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <div v-show="role == 'user'">
          <li class="nav-item m-3">
            <router-link :to="{ name: 'bookInStock' }">
              Book In Stock
            </router-link>
          </li>
          <li class="nav-item m-3">
            <router-link :to="{ name: 'userBorrowed' }"> My Loan </router-link>
          </li>
        </div>
        <div v-show="role == 'admin'">
          <li class="nav-item m-3">
            <router-link :to="{ name: 'books' }"> Books </router-link>
          </li>
          <li class="nav-item m-3">
            <router-link :to="{ name: 'status' }"> Status </router-link>
          </li>
          <li class="nav-item m-3">
            <router-link :to="{ name: 'borrowRequest' }"> Request </router-link>
          </li>
          <li class="nav-item m-3">
            <router-link :to="{ name: 'borrowApproved' }">
              Approved
            </router-link>
          </li>
          <li class="nav-item m-3">
            <router-link :to="{ name: 'borrowBorrowed' }">
              Borrowed
            </router-link>
          </li>
        </div>
        <li class="nav-item m-3" v-show="role">
          <button class="btn btn-info" @click="logout">Logout</button>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import * as authHelper from "../../helper/authHelper";
export default {
  name: "NavbarUser",
  data() {
    return {
      role: "",
    };
  },
  created() {
    this.role = authHelper.getRole();
  },
  watch: {
    $route(to, from) {
      if(from.name == 'login'){
        this.role = authHelper.getRole()
      }
    },
  },
  methods: {
    logout() {
      localStorage.removeItem("Sanc");
      this.role = "";
      this.$router.push({ name: "login" });
    },
  },
};
</script>

<style>
</style>