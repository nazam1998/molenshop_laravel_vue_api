<template>
  <div>
    <v-dialog
      v-model="dialog"
      max-width="600px"
      @click:outside="dialog = false"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" dark v-bind="attrs" v-on="on">
          Edit Product
        </v-btn>
      </template>
      <!-- Vuetify -->
      <v-card>
        <v-card-title>{{ product.name }}</v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  label="Product Name"
                  required
                  type="text"
                  v-model="nameValue"
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  type="number"
                  v-model="price"
                  label="Price"
                  trim
                  min="0"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field
                  type="number"
                  v-model="stock"
                  label="stock"
                  trim
                  min="1"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  label="Description"
                  v-model="descValue"
                  placeholder="Enter something..."
                ></v-textarea>
              </v-col>
              <v-col>
                <v-file-input
                  v-model="cover"
                  @change="editPictureProduct"
                  class="my-3"
                ></v-file-input>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="editProduct()">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "AddProduct",
  props: {
    product: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      nameValue: null,
      descValue: null,
      price: 0,
      stock: 0,
      cover: null,
      msg: [],
      dialog: false,
    };
  },
  mounted() {
    this.nameValue = this.product.name;
    this.descValue = this.product.description;
    this.price = this.product.price;
    this.stock = this.product.stock;
  },
  watch: {
    price: function (value) {
      if (value >= 0) {
        this.price = value;
      }
    },
    stock: function (value) {
      if (value >= 0) {
        this.stock = value;
      } else if (value <= 0) {
        this.stock = 1;
      }
    },
  },
  methods: {
    editProduct: function () {
      let formData = new FormData();
      formData.append("name", this.nameValue);
      formData.append("description", this.descValue);
      formData.append("price", this.price);
      formData.append("stock", this.stock);
      formData.append("_method", "PUT");
      this.$store.dispatch("editProduct", [formData, this.product.id]);
      this.dialog = false;
    },
    editPictureProduct: function () {
      let formData = new FormData();
      formData.append("image", this.cover);
      formData.append("_method", "PUT");
      this.$store.dispatch("editProductPicture", [formData, this.product.id]);
      this.dialog = false;
    },
  },
};
</script>
<style>
</style>