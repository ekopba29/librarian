<template>
  <div>
    <alert :message="message"></alert>
    <div v-if="loading == false">
      <div class="card" v-for="(borrow, key) in borrows" :key="key">
        <div class="card-body">
          {{ borrow.book.judul }} || 
          <button
            v-if="borrow.borrow_status == 3"
            class="btn btn-sm btn-primary"
            @click.prevent="doReturned(borrow.borrow_id)"
          >
            returned
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { doReturned, getBorrowed } from "../../../api/endpointAdmin";
import { headersJsonBarier } from "../../../config/headerAxios";
import NavbarUser from "../../layouts/NavbarUser.vue";
import Alert from "../../../components/Partial/Alert.vue";
export default {
  components: { NavbarUser, Alert },
  name: "Approved",
  data() {
    return {
      borrows: "",
      loading: false,
      notif: "",
      message: "",
    };
  },
  mounted() {
    this.getBorrows();
  },
  methods: {
    getBorrows() {
      this.loading = true;
      axios
        .get(getBorrowed, headersJsonBarier())
        .then((response) => {
          this.borrows = response.data.data.borrows;
        })
        .catch((err) => {
          this.message = err.data.message;
        })
        .finally(() => (this.loading = false));
    },
    doReturned(borrowId) {
      axios
        .get(doReturned.replace("##idBorrow##",borrowId), headersJsonBarier())
        .then((response) => {
          console.log(response);
          this.message = response.data.message;
          this.getBorrows();
        })
        .catch((err) => (this.message = err.data.message))
        .finally(() => (this.loading = false));
    },
  },
};
</script>
