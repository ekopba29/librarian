<template>
  <div>
    <alert :message="message"></alert>
    <div v-if="loading == false">
      <div class="card" v-for="(borrow, key) in borrows" :key="key">
        <div class="card-body">
          {{ borrow.book.judul }} || 
          <button
            v-if="borrow.borrow_status == 1"
            class="btn btn-sm btn-primary"
            @click.prevent="doApprove(borrow.borrow_id)"
          >
            approve
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { doApprove, getBorrowRequest } from "../../api/endpointAdmin";
import { headersJsonBarier } from "../../config/headerAxios";
import NavbarUser from "../Template/NavbarUser.vue";
import Alert from "../Partial/Alert.vue";
export default {
  components: { NavbarUser, Alert },
  name: "BorrowRequest",
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
        .get(getBorrowRequest, headersJsonBarier())
        .then((response) => {
          this.borrows = response.data.data.borrows;
        })
        .catch((err) => {
          this.message = err.data.message;
        })
        .finally(() => (this.loading = false));
    },
    doApprove(borrowId) {
      axios
        .get(doApprove.replace("##idBorrow##",borrowId), headersJsonBarier())
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
