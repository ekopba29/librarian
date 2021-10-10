<template>
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card border-0 shadow rounded-3 my-5">
        <div class="card-body p-4 p-sm-5">
          <h5 class="card-title text-center mb-5 fw-light fs-5">Register</h5>
          <h5
            v-if="error != ''"
            class="card-title text-center mb-5 fw-light fs-5"
          >
            {{ error }}
          </h5>
          <form v-on:submit.prevent="doRegister">
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="floatingInput"
                placeholder="Name Example"
                v-model="formData.name"
              />
              <label for="floatingInput">Name</label>
            </div>
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
              Register
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

export default {
  name: "FormRegister",
  data() {
    return {
      formData: {
        email: "",
        name: "",
        password: "",
      },
      loading: false,
      error: "",
    };
  },
  methods: {
    async doRegister() {
      this.loading = true;
      axios
        .post(authEndpoint.registerUser, this.formData, {
          headers: {
            Accept: "application/json",
          },
        })
        .then((response) => {
          this.$router.push({name:'login'});
        })
        .catch((err) => {
          this.error = err.response.data.message;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>