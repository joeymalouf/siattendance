<template>
  <v-flex xs12 sm11 md7>
    <v-card elevation="12">
      <v-toolbar dark color="#14213d" height="36px">
        <v-toolbar-title>SI Sign Up</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        <v-form>
          <v-text-field v-model="fname" v-validate="'required|max:30'" :counter="30" :error-messages="errors.collect('fname')" label="First Name" data-vv-name="fname" required></v-text-field>
          <v-text-field v-model="lname" v-validate="'required|max:30'" :counter="30" :error-messages="errors.collect('lname')" label="Last Name" data-vv-name="lname" required></v-text-field>
          <v-text-field v-model="id" type="number" v-validate="'required|max:8'" :counter="8" :error-messages="errors.collect('id')" label="Student ID Number" data-vv-name="id" required></v-text-field>
          <v-btn @click="submit">+ Create</v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-flex>
</template>
<script>
export default {
  name: "CreateUser",
  data() {
    return {
      message: "",
      fname: "",
      lname: "",
      id: "",
      dictionary: {
        custom: {
          fname: {
            required: () => "First name cannot be empty."
          },
          lname: {
            required: () => "Last name cannot be empty."
          },
          id: {
            required: () => "Student ID cannot be empty."
          }
        }
      }
    };
  },
  methods: {
    submit() {
      if (this.$validator.validateAll()) {
        var body = new FormData();
        body.append("fname", this.fname);
        body.append("lname", this.lname);
        body.append("id", this.id);
        body.append("func", "createUser");
        this.$http.post("./back/User.php", body).then(
          response => {
            console.log(response.data);
            this.$router.push("/");
          })
          .catch(error => {
            this.message = "Fail";
            console.log(error.data);
          });
      }
    },
  },
  mounted() {
    this.$validator.localize("en", this.dictionary);
  }
};
</script>

