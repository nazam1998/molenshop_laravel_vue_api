<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="600px" @click:outside="dialog=false">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" dark v-bind="attrs" v-on="on">
          Add Product
        </v-btn>
      </template>
      <div data-app>
        <v-card>
          <v-card-title> </v-card-title>
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
                    min="1"
                    step="0.05"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    type="number"
                    v-model="stock"
                    label="Stock"
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
                  <v-file-input v-model="cover" class="my-3"></v-file-input>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="addProduct()">
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </div>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "AddProduct",
  data() {
    return {
      nameValue: null,
      dialog: false,
      descValue: null,
      price: 0,
      stock: 0,
      cover: null,
      msg: [],
    };
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
    addProduct: function () {
      let formData = new FormData();
      formData.append("name", this.nameValue);
      formData.append("description", this.descValue);
      formData.append("price", this.price);
      formData.append("stock", this.stock);
      formData.append("cover", this.cover);

      this.$store.dispatch("addProduct", formData);
      this.nameValue = null;
      this.descValue = null;
      this.cover = null;
      this.price = null;
      this.stock = null;
    },
  },
};
</script>
<style>
</style>