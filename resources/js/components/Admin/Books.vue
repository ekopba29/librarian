<template>
  <div>
    <alert :message="message"></alert>
    
      <router-link :to="{ name: 'booksCreate' }"><button class="btn btn-primary"> Create Book </button></router-link>
    
    <div v-if="loading == false">
      <div class="card" v-for="(book, key) in books" :key="key">
        <div class="card-body">{{ book.judul }} || {{ book.stock }}</div>
          <router-link :to="{ name: 'booksUpdate', params: { idBook: book.id }}">
        <button class="btn btn-info">
            Edit
        </button>
          </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { getBooks } from "../../api/endpointAdmin";
import { headersJsonBarier } from "../../config/headerAxios";
import NavbarUser from "../Template/NavbarUser.vue";
import Alert from "../Partial/Alert.vue";
export default {
  components: { NavbarUser, Alert },
  name: "Books",
  data() {
    return {
      books: "",
      loading: false,
      notif: "",
      message: "",
    };
  },
  mounted() {
    this.getBook();
  },
  methods: {
    getBook() {
      this.loading = true;
      axios
        .get(getBooks, headersJsonBarier())
        .then((response) => {
          this.books = response.data.data.book;
        })
        .catch((err) => {
          console.log(err);
          this.message = err.message;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>
