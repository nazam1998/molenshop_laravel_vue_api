<template>
  <v-app-bar>
    <v-toolbar-title>
      <v-btn @click="$emit('rotate')" tag="span" style="cursor: pointer">
        MoShop
      </v-btn>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-xs-only">
      <v-btn to="/">
        <v-icon>home</v-icon>
        Home
      </v-btn>
      <v-btn v-if="!auth_token" to="/register"> Register </v-btn>
      <v-btn v-if="!auth_token" to="/login"> Login </v-btn>
      <v-btn v-if="auth_token" to="/shops">
        <v-icon class="mdi mdi-shopping"></v-icon>All Shops
      </v-btn>
      <v-btn v-if="auth_token" to="/myorders">
        <v-icon>list</v-icon>My Orders
      </v-btn>
      <v-btn v-if="auth_token" to="/mycart">
        <v-icon class="mdi mdi-cart" v-if="myCart"></v-icon>My Cart
        <v-badge
          class="mx-5 p-5"
          v-if="myCart && myCart.length > 0"
          color="#55f"
          :content="myCart.length"
        ></v-badge>
      </v-btn>
      <v-btn v-if="auth_token" to="/myshop">
        <v-icon class="mdi mdi-shopping"></v-icon>My Shop
      </v-btn>
      <v-menu v-if="auth_token && currentUser">
        <template v-slot:activator="{ on, attrs }">
          <v-btn v-bind="attrs" v-on="on">
            <v-icon>person</v-icon>{{ currentUser.profile.firstname }}
          </v-btn>
        </template>
        <v-list>
          <v-list-item to="/profil"> Profile </v-list-item>
          <v-list-item @click="$store.dispatch('logout')"> Logout </v-list-item>
        </v-list>
      </v-menu>
    </v-toolbar-items>
  </v-app-bar>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "NavBar",
  computed: {
    ...mapState(["currentUser", "auth_token", "myCart"]),
  },
};
</script>
<style scoped>
a.nav-link {
  color: white;
}
</style>