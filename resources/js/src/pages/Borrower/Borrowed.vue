<template>
  <div>
    <alert :message="message"></alert>
    <div v-if="loading == false">
      <div class="card" v-for="(borrow, key) in borrows" :key="key">
        <div class="card-body">
          {{ borrow.book.judul }} || 
          <div v-if="borrow.borrow_status == 1">Request</div>
          <div v-if="borrow.borrow_status == 2">Approve</div>
          <div v-if="borrow.borrow_status == 3">Borrowed</div>
          <div v-if="borrow.borrow_status == 4">Returned</div>
          <div v-if="borrow.borrow_status == 5">Cancelled</div>
          <button
            v-if="borrow.borrow_status == 1"
            class="btn btn-sm btn-primary"
            @click.prevent="doCancelBorrow(borrow.borrow_id)"
          >
            cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { doCancelBorrow, bookBorrowed } from "../../../api/endpointBorrower";
import { headersJsonBarier } from "../../../config/headerAxios";
import NavbarUser from "../../layouts/NavbarUser.vue";
import Alert from "../../../components/Partial/Alert.vue";
export default {
  components: { NavbarUser, Alert },
  name: "userBorrowed",
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
        .get(bookBorrowed, headersJsonBarier())
        .then((response) => {
          this.borrows = response.data.data.borrows;
        })
        .catch((err) => {
          this.message = err.message;
        })
        .finally(() => (this.loading = false));
    },
    doCancelBorrow(bookId) {
      axios
        .get(doCancelBorrow.replace("##idBorrow##",bookId), headersJsonBarier())
        .then((response) => {
          console.log(response);
          this.getBorrows();
        })
        .catch((err) => (this.message = err.data.message))
        .finally(() => (this.loading = false));
    },
  },
};
</script>
