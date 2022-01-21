<template>
  <div id="inspire">
    <v-app app>
      <nav-bar
        @setDrawer="drawer = !drawer"
        @rotate="$store.commit('setRotate')"
      />
      <v-navigation-drawer app v-model="drawer">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="text-h6"> Moshop </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-spacer></v-spacer>
        <v-list>
          <v-list-item to="/">
            <v-list-item-icon class="mdi mdi-home"></v-list-item-icon>
            <v-list-item-content>Home</v-list-item-content>
          </v-list-item>
          <v-list-item v-if="auth_token" to="/shops" link>
            <v-list-item-icon class="mdi mdi-shopping"></v-list-item-icon>
            <v-list-item-content>All Shops</v-list-item-content>
          </v-list-item>

          <v-list-item v-if="auth_token" to="/myorders" link>
            <v-list-item-icon
              class="mdi mdi-format-list-bulleted"
            ></v-list-item-icon>
            <v-list-item-content>My Orders</v-list-item-content>
          </v-list-item>
          <v-list-item v-if="auth_token" to="/myshop">
            <v-list-item-icon class="mdi mdi-shopping"></v-list-item-icon>
            <v-list-item-content>My Shop</v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>

      <v-main class="">
        <v-alert
          v-if="message"
          :type="message.type"
          dismissible
          class="mt-1 mb-5"
        >
          {{ message.text }}
          <v-row v-if="message.errors">
            <v-col
              cols="12"
              v-for="(error, index) in message.errors"
              :key="index"
            >
              *<span v-for="(msg, errInd) in error" :key="errInd">
                {{ msg }}
              </span>
            </v-col>
          </v-row>
        </v-alert>

        <router-view />
        <v-btn
          elevation="2"
          fab
          fixed
          right
          bottom
          @click="$vuetify.theme.dark = !$vuetify.theme.dark"
        >
          <v-icon
            :class="{
              mdi: true,
              'mdi-moon-first-quarter': $vuetify.theme.dark,
              'mdi-weather-sunny': !$vuetify.theme.dark,
            }"
          ></v-icon>
        </v-btn>
      </v-main>
    </v-app>
  </div>
</template>
<script>
import NavBar from "@/components/NavBar.vue";
import { mapState } from "vuex";
export default {
  name: "App",
  components: { NavBar },
  data() {
    return { drawer: false };
  },
  mounted() {
    if (this.$store.state.auth_token) {
      this.$store.dispatch("getMyCart");
    }
  },
  methods: {
    setDrawer() {
      if (this.drawer == true) {
        this.drawer = false;
      }
    },
  },
  computed: {
    ...mapState(["message", "auth_token"]),
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
