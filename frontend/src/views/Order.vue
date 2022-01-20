<template>
  <v-container v-if="order">
    <h3 class="text-center">Your order on {{ orderDate }}</h3>
    <v-row class="my-5 justify-content-between text-left border-bottom pv-4">
      <v-col cols="1">ID</v-col>
      <v-col cols="1"></v-col>
      <v-col cols="4">Product</v-col>
      <v-col cols="1">Quantity</v-col>
      <v-col cols="2">Unit Price</v-col>
      <v-col cols="2">Total Price</v-col>
    </v-row>
    <v-row
      class="my-5 justify-content-between text-left align-items-center"
      :class="{'deleted':item.product.deleted_at}"
      tag="li"
      v-for="item in order_items"
      :key="item.id"
    >
      <v-col cols="1" class="border-right">{{ item.id }}</v-col>
      <v-col cols="1"
        ><v-img
          class="img-fluid"
          max-width="100"
          max-height="100"
          :src="storageUrl + item.product.cover_path"
          alt=""
        ></v-img>
      </v-col>
      <v-col cols="4" class="border-right">{{ item.product.name }}</v-col>
      <v-col cols="1" class="border-right">{{ item.quantity }}</v-col>
      <v-col cols="2" class="border-right">{{ item.product.price.toFixed(2) }}€</v-col>
      <v-col cols="2"
        >{{ (item.product.price * item.quantity).toFixed(2) }}€</v-col
      >
      <v-card-title v-if="item.product.deleted_at" class="title">Product Not Available Anymore</v-card-title>
    </v-row>
    <h3 class="text-center">Total Order Price: {{ order.price.toFixed(2) }}€</h3>
  </v-container>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";

export default {
  name: "Order",
  data() {
    return {
      order: null,
      order_items: null,
    };
  },
  props: {
    orderid: {
      type: [String, Number],
      required: true,
    },
  },
  mounted() {
    let auth_token = this.auth_token;
    axios
      .get("/api/v1/order/" + this.orderid, {
        headers: {
          Authorization: "Bearer " + auth_token,
        },
      })
      .then((resp) => {
        this.order = resp.data.data.order;
        this.order_items = resp.data.data.order_items;
      });
  },
  computed: {
    orderDate: function () {
      let formatdate = new Date(this.order.date);
      let year = formatdate.getFullYear();
      let month = formatdate.getMonth() + 1;
      let day = formatdate.getDate();
      let hour = formatdate.getHours();
      let minutes = formatdate.getMinutes();
      let seconds = formatdate.getSeconds();
      return (
        day +
        "/" +
        month +
        "/" +
        year +
        " at " +
        hour +
        ":" +
        minutes +
        ":" +
        seconds
      );
    },
    ...mapState(["auth_token"]),
  },
};
</script>
<style scoped>
.deleted{
  background-color: rgba(255,0,0,0.2);
  opacity: 0.8;
}
.deleted .title{
  color: white;
  opacity: 1;
}
</style>