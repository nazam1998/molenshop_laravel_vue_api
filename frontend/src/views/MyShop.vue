<template>
  <v-container class="shop">
    <h2 class="text-center" v-if="myShop">{{ myShop.name }}</h2>
    <AddProduct />
    <h3 class="my-3">Products</h3>
    <v-row v-if="myShop">
      <v-col v-for="product in myShop.products" :key="product.id" cols="4">
        <v-card img-top tag="article" style="height: 100%" class="mv-2 p-3">
          <v-card-title>{{ product.name }}</v-card-title>
          <v-img max-width="300" max-height="300" :src="storageUrl + product.cover_path">
          </v-img>
          <v-card-text>
            {{ product.description.substring(0, 50) + "..." }}
          </v-card-text>
          <v-card-subtitle>Price: {{ product.price }}€</v-card-subtitle>
          <v-card-subtitle>Left: {{ product.stock }}</v-card-subtitle>
          <v-card-actions class="product-action">
            <edit-product :product="product"></edit-product>
            <v-btn @click="deleteProduct(product.id)" color="orange"
            class="mx-5"
              ><v-icon class="delete"
            /></v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapState } from "vuex";
import AddProduct from "@/components/AddProduct.vue";
import EditProduct from "@/components/EditProduct.vue";
export default {
  name: "Shop",
  components: {
    AddProduct,
    EditProduct,
  },
  data() {
    return {
      showActions: [],
    };
  },
  computed: {
    ...mapState(["myShop"]),
  },
  methods: {
    deleteProduct: function (product_id) {
      this.$store.dispatch("deleteProduct", product_id);
    },
  },
  async mounted() {
    await this.$store.dispatch("getMyShop");
    this.showActions = [];
    let showActions = this.showActions;
    this.myShop.products.forEach(function () {
      showActions.push(false);
    });
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.btn-cart {
  position: relative;
  bottom: 0px;
}
</style>
