<template>
  <v-container v-if="orders">
    <div v-if="orders.length > 0">
      <v-row class="mt-5 mv-2 justify-content-between text-left">
        <v-col cols="1">ID</v-col>
        <v-col cols="6">Date</v-col>
        <v-col cols="3">Price</v-col>
        <v-col cols="2">Action</v-col>
      </v-row>
      <v-row
        class="justify-content-between text-left py-3 px-1"
        tag="li"
        v-for="order in orders"
        :key="order.id"
      >
        <v-col cols="1" class="border-right">{{ order.id }}</v-col>
        <v-col cols="6" class="border-right">{{ orderDate(order.date) }}</v-col>
        <v-col cols="3" class="border-right">{{ order.price }}€</v-col>
        <v-col cols="2"
          ><router-link :to="{ name: 'Order', params: { orderid: order.id } }"
            ><v-btn>View Details</v-btn></router-link
          ></v-col
        >
      </v-row>
    </div>
    <h2 v-else>No orders</h2>
  </v-container>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "MyOrders",
  mounted() {
    this.$store.dispatch("getOrders");
  },
  methods: {
    orderDate: function (date) {
      let formatdate = new Date(date);
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
        " " +
        hour +
        ":" +
        minutes +
        ":" +
        seconds
      );
    },
  },
  computed: {
    ...mapState(["orders"]),
  },
};
</script>
<style scoped>
li {
  border: 1px solid;
}
</style>