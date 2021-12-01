<template>
  <div>
    <alert :message="message"></alert>
    <div v-if="loading == false">
      <div class="card" v-for="(book, key) in books" :key="key">
        <div class="card-body">
          {{ book.judul }} ||
          <button
            class="btn btn-sm btn-primary"
            @click.prevent="doBorrow(book.id)"
          >
            pinjam
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { bookInStock, doBorrow } from "../../../api/endpointBorrower";
import { headersJsonBarier } from "../../../config/headerAxios";
import NavbarUser from "../../layouts/NavbarUser.vue";
import Alert from "../../../components/Partial/Alert.vue";
export default {
  components: { NavbarUser, Alert },
  name: "BookInStock",
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
        .get(bookInStock, headersJsonBarier())
        .then((response) => {
          this.books = response.data.data.book;
        })
        .catch((err) => {
          console.log(err);
          this.message = err.message;
        })
        .finally(() => (this.loading = false));
    },
    doBorrow(bookId) {
      axios
        .get(doBorrow + bookId, headersJsonBarier())
        .then((response) => {
          console.log(response);
          this.message = response.data.message;
          this.getBook();
        })
        .catch((err) => (this.message = err.data.message))
        .finally(() => (this.loading = false));
    },
  },
};
</script>
