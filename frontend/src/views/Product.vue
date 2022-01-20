<template>
  <v-container v-if="product">
    <v-row class="align-items">
      <v-col cols="6">
        <v-img
          :src="storageUrl + product.cover_path"
          alt=""
        ></v-img>
      </v-col>
      <v-col cols="6" class="product-desc">
        <v-row align="between" height="100%">
          <v-col cols="12">
            <h2>{{ product.name }}</h2>
          </v-col>
          <v-col cols="12">
            <p>{{ product.description }}</p>
          </v-col>
          <v-col cols="12">
            <p>{{ product.stock }}</p>
          </v-col>
          <v-col cols="12">
            <h5>{{ product.price }}€</h5>
          </v-col>
        </v-row>
        <div
          class="add-cart-section"
          v-if="product.shop_id != currentUser.shop.id"
        >
          <v-text-field
            v-if="product.stock > 0"
            class="w-50 mv-0"
            id="input-1"
            v-model="currentQuantity"
            type="number"
            trim
            min="1"
          ></v-text-field>
          <v-btn
            v-if="product.stock > 0"
            variant="primary"
            class="btn-cart my-2"
            @click="addCart"
            >Add to cart</v-btn
          >
          <v-btn v-else disabled>Out of stock</v-btn>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
export default {
  data() {
    return {
      currentQuantity: 1,
      product: null,
      message: null,
    };
  },
  props: {
    productid: {
      type: [Number, String],
      required: true,
    },
  },
  mounted() {
    this.getProduct();
  },
  methods: {
    async addCart() {
      let formData = new FormData();
      formData.append("product", this.product.id);
      formData.append("quantity", this.currentQuantity);
      await this.$store.dispatch("addToCart", formData);
      this.currentQuantity = this.product.stock - this.currentQuantity;
      this.getProduct();
    },
    getProduct() {
      axios
        .get("/api/v1/product/" + this.productid, {
          headers: {
            Authorization: "Bearer " + this.auth_token,
          },
        })
        .then((resp) => {
          console.log(resp.data);
          this.product = resp.data.data;
        });
    },
  },
  watch: {
    currentQuantity: function (value) {
      if (value >= 1) {
        this.message = "";
        if (value > this.product.stock) {
          this.currentQuantity = 1;
        } else {
          this.currentQuantity = value;
        }
      } else {
        this.message = "You must enter at least one quantity";
      }
    },
  },
  computed: {
    ...mapState(["auth_token", "currentUser"]),
  },
};
</script>
<style scoped>
.product-desc {
  position: relative;
}
.add-cart-section {
  position: absolute;
  bottom: 0;
  text-align: left;
}
</style>