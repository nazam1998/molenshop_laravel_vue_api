<template>
  <v-container v-if="myCart">
    <h2>
      {{ fullname }}'s Cart <span v-if="myCart.length <= 0">is empty</span>
    </h2>
    <v-row class="justify-content-between mt-5" v-if="myCart.length > 0">
      <v-col cols="3"></v-col>
      <v-col cols="3">Product Name</v-col>
      <v-col cols="1">Quantity</v-col>
      <v-col cols="1">Unit Price</v-col>
      <v-col cols="1">Total Price</v-col>
      <v-col cols="1"></v-col>
    </v-row>
    <v-list v-if="myCart.length > 0">
      <v-list-item
        v-for="item in myCart"
        :key="item.id"
        :class="{ deleted: item.product.deleted_at }"
      >
        <v-row
          class="align-items-center p-2 justify-content-between"
          align="center"
          v-if="item.product"
        >
          <v-col cols="3"
            ><v-img
              class="img-fluid"
              max-width="100"
              max-height="100"
              :src="'http://127.0.0.1:8000/storage/' + item.product.cover_path"
              alt=""
            ></v-img>
          </v-col>
          <v-col cols="3">{{ item.product.name }}</v-col>
          <v-col cols="1">{{ item.quantity }}</v-col>
          <v-col cols="1">{{ item.product.price.toFixed(2) }}€</v-col>
          <v-col cols="1"
            >{{ (item.product.price * item.quantity).toFixed(2) }}€</v-col
          >
          <v-col cols="1"
            ><v-btn color="red" @click="removeFromCart(item.id)"
              ><v-icon>delete</v-icon></v-btn
            ></v-col
          >
        </v-row>
      </v-list-item>
    </v-list>
    <div class="mx-auto text-center" v-if="myCart.length > 0">
      <h3 class="my-5" v-if="containsDeleted.length <= 0">
        Total Price: {{ totalPrice.toFixed(2) }}€
      </h3>
      <v-btn
        variant="success"
        class="mx-auto"
        v-if="myCart.length != 0 && containsDeleted.length == 0"
        @click="confirm"
      >
        Confirm Order
      </v-btn>
      <v-btn color="orange" v-else-if="containsDeleted.length != 0">
        Some items are not available anymore, please delete them from your cart
        before proceeding.
      </v-btn>
    </div>
  </v-container>
</template>
<script>
import { mapState } from "vuex";
export default {
  name: "Panier",
  data() {
    return {};
  },
  mounted() {
    this.$store.dispatch("getMyCart");
  },
  methods: {
    confirm() {
      this.$store.dispatch("confirmOrder");
    },
    removeFromCart(id) {
      this.$store.dispatch("removeFromCart", id);
    },
  },
  computed: {
    fullname: function () {
      return (
        this.currentUser.profile.lastname +
        " " +
        this.currentUser.profile.firstname
      );
    },
    containsDeleted: function () {
      return this.myCart.filter((elem) => {
        return elem.product.deleted_at;
      });
    },

    totalPrice: function () {
      let totalPrice = 0;
      this.myCart.forEach((elem) => {
        if (!elem.product.deleted_at) {
          totalPrice += elem.product.price * elem.quantity;
        }
      });
      return totalPrice;
    },
    ...mapState(["myCart", "currentUser"]),
  },
};
</script>
<style scoped>
ul li {
  border: 1px solid grey;
}
.deleted {
  background-color: rgba(0, 0, 0, 0.3);
}
</style>