<template>
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card border-0 shadow rounded-3 my-5">
        <div class="card-body p-4 p-sm-5">
          <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
          <h5
            v-if="error != ''"
            class="card-title text-center mb-5 fw-light fs-5"
          >
            {{ error }}
          </h5>
          <form v-on:submit.prevent="doLogin">
            <div class="form-floating mb-3">
              <input
                type="email"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
                v-model="formData.email"
              />
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Password"
                v-model="formData.password"
              />
              <label for="floatingPassword">Password</label>
            </div>
            <button
              v-if="loading == false"
              type="submit"
              class="btn btn-primary"
            >
              Login
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import * as authEndpoint from "../../api/endpointAuth";
import * as authHelper from "../../helper/authHelper";
export default {
  name: "FormLogin",
  data() {
    return {
      formData: {
        email: "",
        password: "",
      },
      loading: false,
      error: "",
    };
  },
  methods: {
    redirect() {
      const role = authHelper.getRole();
      if (role == "admin") {
        this.$router.push({ name: "borrowRequest" });
      } else if (role == "user") {
        this.$router.push({ name: "bookInStock" });
      }
    },
    setCookie() {
      axios
        .get(authEndpoint.requestCookie)
        .then((response) => {
          // this.redirect();
        })
        .catch((err) => {
          console.log(err);
          // this.error = message;
        })
        .finally(() => (this.loading = false));
    },
    doLogin() {
      this.loading = true;
      axios
        .post(authEndpoint.requestToken, this.formData, {
          headers: {
            Accept: "application/json",
          },
        })
        .then((response) => {
          localStorage.setItem("Sanc", JSON.stringify(response.data.data));
          this.redirect();
        })
        .catch((err) => {
          this.error = err.response.data.message;
        })
        .finally(() => (this.loading = false));
    },
  },
  mounted() {
    this.setCookie();
  },
};
</script>