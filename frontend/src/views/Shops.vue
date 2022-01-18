<template>
  <div class="home text-white">
    <h1 class="text-center">
      Molengeek Shop

      <h5 class="my-4">Select a shop and start buying products</h5>
    </h1>
    <v-container v-if="shops" class="my-5">
      <v-row class="justify-content-between">
        <router-link
          class="col-5 border rounded m-2 p-2 text-dark text-center"
          v-for="shop in shops"
          :key="shop.id"
          :to="{ name: 'Shop', params: { shopid: shop.id } }"
        >
          <v-card>
            <v-card-title>{{ shop.name }}</v-card-title>
            <v-card-text>Products: {{shop.products.length}}</v-card-text>
          </v-card>
        </router-link>
      </v-row>
    </v-container>
  </div>
</template>

<script>
// @ is an alias to /src
import { mapState } from "vuex";
export default {
  name: "Home",

  mounted() {
    this.$store.dispatch("getShops");
  },
  computed: {
    ...mapState(["shops"]),
  },
};
</script>
<style scoped>
.home::before {
  content: "";
  position: fixed;
  left: 0;
  right: 0;
  z-index: -1;

  display: block;
  /* background-image: url("https://images.unsplash.com/photo-1641124963830-09ec18e8aae1?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80"); */
  background-size: cover;
  width: 100%;
  height: 100%;

  -webkit-filter: blur(5px);
  -moz-filter: blur(5px);
  -o-filter: blur(5px);
  -ms-filter: blur(5px);
  filter: blur(5px);
}
li {
  list-style: none;
}
</style>