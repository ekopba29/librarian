<template>
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card border-0 shadow rounded-3 my-5">
        <div class="card-body p-4 p-sm-5">
          <h5
            v-if="error != '' || success != ''"
            class="card-title text-center mb-5 fw-light fs-5"
          >
            {{ error }}
            {{ success }}
          </h5>
          <div v-if="curPath == '/admin/books/create'">
            <h2>Create Book</h2>
          </div>
          <div v-else>
            <h2>Update Book</h2>
          </div>
          <form v-on:submit.prevent="doSaveBook">
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="judul"
                v-model="formData.judul"
              />
              <label for="floatingInput">Judul</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="deskripsi"
                v-model="formData.deskripsi"
              />
              <label for="floatingPassword">Deskripsi</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="stock"
                v-model="formData.stock"
              />
              <label for="floatingPassword">Stock</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="category"
                v-model="formData.category"
              />
              <label for="floatingPassword">category</label>
            </div>
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="pengarang"
                v-model="formData.pengarang"
              />
              <label for="floatingPassword">Pengarang</label>
            </div>
            <button
              v-if="loading == false"
              type="submit"
              class="btn btn-primary"
            >
              Save
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import * as adminEndpoint from "../../../api/endpointAdmin";
import { headersJsonBarier } from "../../../config/headerAxios";

export default {
  name: "FormLogin",
  mounted() {
    this.idBook = this.$route.params.idBook;
    if (this.curPath != "/admin/books/create") {
      this.getDataBook(this.idBook);
    }
  },
  data() {
    return {
      idBook: "",
      formData: {
        judul: "",
        deskripsi: "",
        pengarang: "",
        stock: "",
        category: "",
      },
      curPath: window.location.pathname,
      loading: false,
      error: "",
      success: "",
    };
  },
  methods: {
    async getDataBook() {
      axios
        .get(
          adminEndpoint.getBook.replace("##idBook##", this.idBook),
          headersJsonBarier()
        )
        .then((response) => {
          this.formData = response.data.data;
        })
        .catch((err) => console.log(err));
    },
    async setCookie() {
      axios
        .get(authEndpoint.requestCookie)
        .then((response) => {})
        .catch((err) => {
          this.error = err.response.data.message;
        })
        .finally(() => (this.loading = false));
    },
    async createBook() {
      axios
        .post(adminEndpoint.createBooks, this.formData, headersJsonBarier())
        .then((response) => {
          if (response.data.status == "OK") {
            this.success = "Book Saved";
            this.error = "";
          }
        })
        .catch((err) => {
          this.error = err.response.data.message;
        })
        .finally(() => (this.loading = false));
    },
    async updateBook() {
      axios
        .put(
          adminEndpoint.updateBooks.replace("##idBook##", this.idBook),
          this.formData,
          headersJsonBarier()
        )
        .then((response) => {
          if (response.data.status == "OK") {
            this.success = "Book Saved";
          }
        })
        .catch((err) => {
          this.error = err.response.data.message;
        })
        .finally(() => (this.loading = false));
    },
    async doSaveBook() {
      this.loading = true;
      if (this.curPath == "/admin/books/create") {
        this.createBook();
      } else {
        this.updateBook();
      }
    },
  },
};
</script>