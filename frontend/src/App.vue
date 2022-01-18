<template>
  <div id="app">
    <nav-bar />
    <v-app>
      <v-alert v-if="message" :type="message.type" dismissible class="my-10">
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
      <v-container class="my-10">
        <router-view />
      </v-container>
    </v-app>
  </div>
</template>
<script>
import NavBar from "@/components/NavBar.vue";
import { mapState } from "vuex";
export default {
  name: "App",
  components: { NavBar },
  mounted() {
    if (this.$store.state.auth_token) {
      this.$store.dispatch("getMyCart");
    }
  },
  computed: {
    ...mapState(["message"]),
  },
};
</script>
<style>
</style>
