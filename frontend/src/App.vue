<template>
  <div id="app">
    <v-app app>
    <nav-bar @rotate="$store.commit('setRotate')" />
      <v-alert v-if="message" :type="message.type" dismissible class="my-8">
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
