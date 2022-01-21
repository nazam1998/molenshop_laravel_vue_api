<template lang="">
    <v-col
        cols="12"
        md="4"
        class="my-3"
      >
        <v-card >
          <v-card-title>{{ product.name }}</v-card-title>
          <v-img :class="{ rotating: $store.state.rotate }" max-height="250" max-width="250" :src="storageUrl + product.cover_path">
          </v-img>
          <v-card-text>
            {{ product.description.substring(0, 50) + "..." }} <router-link :to="{name:'Product', params:{productid:product.id}}">Read more</router-link>
          </v-card-text>
          <v-card-subtitle>Price: {{ product.price }}€</v-card-subtitle>
          <v-card-subtitle>Left: {{ product.stock }}</v-card-subtitle>
          <v-card-actions v-if="auth_token">
              <v-row class="mx-5" v-if="(currentQuantity>0) && myShop">
                <v-col cols="12" v-if="myShop.id != product.shop_id">
                  <v-text-field   
                  class="w-50 mv-0"
                  id="input-1"
                  v-model="currentQuantity"
                  type="number"
                  trim
                  min="1"
                  :max="product.stock"
                ></v-text-field>  
                </v-col>
                <v-col cols="12" v-if="myShop.id != product.shop_id">
                  <v-btn
                    variant="primary"
                    class="btn-cart my-2"
                    @click="addCart"
                    >Add to cart</v-btn
                  >
                </v-col>
            </v-row>
          <v-btn v-else disabled>Out of stock</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "Product",
  data() {
    return {
      currentQuantity: 1,
    };
  },
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
  mounted() {
    this.currentQuantity = this.product.stock;
    if (this.$store.state.auth_token) {
      this.$store.dispatch("getMyShop");
    }
  },
  methods: {
    async addCart() {
      let formData = new FormData();
      formData.append("product", this.product.id);
      formData.append("quantity", this.currentQuantity);
      await this.$store.dispatch("addToCart", formData);
      this.currentQuantity = this.product.stock - this.currentQuantity;
      await this.$emit("getShop");
    },
  },
  watch: {
    currentQuantity: function (value) {
      if (value > 0) {
        if (value <= this.product.stock) {
          this.currentQuantity = value;
        } else {
          this.currentQuantity = 1;
        }
      }
    },
  },
  computed: {
    ...mapState(["myShop", "auth_token"]),
  },
};
</script>
<style scoped>
@-webkit-keyframes rotating /* Safari and Chrome */ {
  from {
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes rotating {
  from {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.rotating {
  -webkit-animation: rotating 2s linear;
  -moz-animation: rotating 2s linear;
  -ms-animation: rotating 2s linear;
  -o-animation: rotating 2s linear;
  animation: rotating 2s linear;
}
</style>