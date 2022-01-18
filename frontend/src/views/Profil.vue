<template>
  <v-container>
    <h3 class="my-4">My Profil</h3>
    <v-row class="align-items-center">
      <v-col cols="6"
        ><img class="img-fluid img-profile" :src="profilPicture" />
        <div class="my-2"></div>

        <v-file-input
          class="my-3"
          v-model="file"
          v-if="editPicture && !editMode"
        ></v-file-input>
        <v-btn
          @click="savePicture"
          variant="success"
          v-if="editPicture && !editMode"
          >Save Picture</v-btn
        ></v-col
      >
      <v-col offset="1" cols="5" class="text-left">
        <p>
          <span class="font-weight-bold">First Name:</span>
          {{ currentUser.profile.firstname }}
        </p>
        <p>
          <span class="font-weight-bold">First Name:</span>
          {{ currentUser.profile.lastname }}
        </p>
        <p>
          <span class="font-weight-bold">Email:</span> {{ currentUser.email }}
        </p>

        <div
          v-if="editMode && !editPicture"
          id="fieldset-1"
          label="Enter your First Name"
          label-for="input-1"
          valid-feedback="Thank you!"
        >
          <v-text-field
            id="input-1"
            type="text"
            v-model="firstNameValue"
            trim
          ></v-text-field>
        </div>
        <div
          v-if="editMode && !editPicture"
          id="fieldset-1"
          label="Enter your Last Name"
          label-for="input-1"
          valid-feedback="Thank you!"
        >
          <v-text-field
            id="input-1"
            type="text"
            v-model="lastNameValue"
            trim
          ></v-text-field>
        </div>
        <v-btn
          @click="saveProfile"
          v-if="editMode && !editPicture"
          variant="success"
          >Save Profile</v-btn
        ></v-col
      >
    </v-row>
    <v-row>
      <v-col cols="6"
        ><v-btn
          @click="editPicture = !editPicture"
          v-if="!editMode"
          class="my-3"
          variant="info"
          >{{ editPicture ? "Cancel" : "Edit Picture" }}</v-btn
        ></v-col
      >
      <v-col cols="6"
        ><v-btn
          @click="editMode = !editMode"
          v-if="!editPicture"
          class="my-3"
          variant="danger"
          >{{ editMode ? "Cancel" : "Edit Profil" }}</v-btn
        ></v-col
      >
    </v-row>
  </v-container>
</template>
<script>
import { mapState } from "vuex";
export default {
  name: "Profil",
  data() {
    return {
      firstNameValue: null,
      lastNameValue: null,
      file: null,
      editMode: false,
      editPicture: false,
      msg: [],
    };
  },
  mounted() {
    this.firstNameValue = this.currentUser.profile.firstname;
    this.lastNameValue = this.currentUser.profile.lastname;
  },
  methods: {
    savePicture: function () {
      if (this.file) {
        let formData = new FormData();
        formData.append("image", this.file);
        formData.append("_method", "PUT");
        this.$store.dispatch("editPicture", formData);
      }
    },
    saveProfile: function () {
      if (this.firstNameValue && this.lastNameValue) {
        let formData = new FormData();
        formData.append("firstname", this.firstNameValue);
        formData.append("lastname", this.lastNameValue);
        formData.append("_method", "PUT");
        this.$store.dispatch("editProfile", formData);
        this.editMode = !this.editMode;
      }
    },
  },
  computed: {
    fullname: function () {
      return (
        this.currentUser.profile.firstname +
        " " +
        this.currentUser.profile.lastname
      );
    },
    profilPicture: function () {
      return (
        "http://127.0.0.1:8000/storage/" + this.currentUser.profile.picture_path
      );
    },
    ...mapState(["currentUser"]),
  },
};
</script>
<style scoped>
.img-profile {
  height: 400px;
  width: 400px;
}
</style>