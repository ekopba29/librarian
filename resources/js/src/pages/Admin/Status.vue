<template>
 <div>
   Request -> Approve/Cancel ->[if approve] Borrowed -> Returned 
 </div>
</template>

<script>
import axios from "axios";
import { doBorrowed, getBorrowApproved } from "../../../api/endpointAdmin";
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
        .get(getBorrowApproved, headersJsonBarier)
        .then((response) => {
          this.borrows = response.data.data.borrows;
        })
        .catch((err) => {
          this.message = err.data.message;
        })
        .finally(() => (this.loading = false));
    },
    doBorrowed(borrowId) {
      axios
        .get(doBorrowed.replace("##idBorrow##",borrowId), headersJsonBarier)
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
