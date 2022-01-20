<template>
  <v-container class="text-left border p-4">
    <v-text-field
      id="input-1"
      label="First Name"
      type="text"
      v-model="firstNameValue"
      trim
    ></v-text-field>

    <v-text-field
      id="input-1"
      type="text"
      label="Last Name"
      v-model="lastNameValue"
      trim
    ></v-text-field>

    <v-text-field
      id="input-1"
      type="email"
      label="Email"
      v-model="emailValue"
      trim
    ></v-text-field>

    <v-text-field
      type="password"
      id="input-1"
      label="Password"
      v-model="passwordValue"
      trim
    ></v-text-field>
    <v-file-input
      label="Profil Picture"
      v-model="file"
      class="my-3"
    ></v-file-input>
    <v-btn @click="register">Register</v-btn>
  </v-container>
</template>
<script>
import axios from "axios";
export default {
  name: "Login",
  data() {
    return {
      firstNameValue: null,
      lastNameValue: null,
      emailValue: null,
      passwordValue: null,
      file: null,
      msg: [],
    };
  },
  watch: {
    firstNameValue: function (value) {
      if (!value) {
        if (!this.msg.includes("firstName")) {
          this.msg.push("firstName");
        }
      } else {
        this.msg.splice(this.msg.indexOf("firstName"), 1);
      }
    },
    lastNameValue: function (value) {
      if (!value) {
        if (!this.msg.includes("lastName")) {
          this.msg.push("lastName");
        }
      } else {
        this.msg.splice(this.msg.indexOf("lastName"), 1);
      }
    },
    emailValue: function (value) {
      if (!value || !value.includes("@")) {
        if (!this.msg.includes("email")) {
          this.msg.push("email");
        }
      } else {
        this.msg.splice(this.msg.indexOf("email"), 1);
      }
    },
    passwordValue: function (value) {
      if (!value || value.length < 4) {
        if (!this.msg.includes("password")) {
          this.msg.push("password");
        }
      } else {
        this.msg.splice(this.msg.indexOf("password"), 1);
      }
    },
    file: function (value) {
      if (
        !value ||
        value.size > 2048 * 2048 ||
        value.type !== "image/jpeg" ||
        value.type !== "image/jpg" ||
        value.type !== "image/png"
      ) {
        if (!this.msg.includes("file")) {
          this.msg.push("file");
        }
      } else {
        this.msg.splice(this.msg.indexOf("file"), 1);
      }
    },
  },
  methods: {
    register: function () {
      const formData = new FormData();
      formData.append("firstname", this.firstNameValue);
      formData.append("lastname", this.lastNameValue);
      formData.append("email", this.emailValue);
      formData.append("password", this.passwordValue);
      formData.append("picture", this.file);
      let data = {
        email: this.emailValue,
        password: this.passwordValue,
      };

      axios
        .post("/api/v1/register", formData)
        .then(() => {
          this.$store.dispatch("login", data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
<style scoped>
</style>