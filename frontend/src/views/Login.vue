<template>
  <v-container>
      <v-row>
        <v-col cols="12" md="6">
          <v-text-field
            v-model="emailValue"
            label="E-mail"
            name="email"
            type="email"
            required
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="6">
          <v-text-field
            v-model="passwordValue"
              @keyup.enter="login"
            name="password"
            label="Password"
            type="password"
            required
          ></v-text-field>
        </v-col>
        <v-btn @click="login" class="mt-3">Login</v-btn>
      </v-row>
    </v-container>
</template>
<script>
export default {
  name: "Login",
  data() {
    return {
      emailValue: null,
      passwordValue: null,
    };
  },
  methods: {
    login: function () {
      let data = {
        email: this.emailValue,
        password: this.passwordValue,
      };

      this.$store.dispatch("login", data);
    },
  },
};
</script>
<style scoped>
</style>