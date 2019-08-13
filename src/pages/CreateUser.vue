<template>
  <v-flex xs12 sm11 md7>
    <v-card elevation="12">
      <v-toolbar dark color="#14213d" height="36px">
        <v-toolbar-title>SI Sign Up</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        <v-form>
          <v-text-field
            v-model="fname"
            v-validate="'required|max:30'"
            :counter="30"
            :error-messages="errors.collect('fname')"
            label="First Name"
            data-vv-name="fname"
            required
          ></v-text-field>
          <v-text-field
            v-model="lname"
            v-validate="'required|max:30'"
            :counter="30"
            :error-messages="errors.collect('lname')"
            label="Last Name"
            data-vv-name="lname"
            required
          ></v-text-field>
          <v-text-field
            v-model="id"
            type="number"
            v-validate="'required|max:8|min:8'"
            :counter="8"
            :error-messages="errors.collect('id')"
            label="Student ID Number"
            data-vv-name="id"
            required
          ></v-text-field>
          <v-text-field
            v-model="email"
            v-validate="'required|email'"
            :error-messages="errors.collect('email')"
            label="Student E-mail"
            required
            data-vv-name="email"
          ></v-text-field>
          <v-btn @click="submit">+ Create</v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-flex>
</template>
<script>
import { statusCodeHandler } from "../handlers/HttpStatusCodeHandler";

export default {
  name: "CreateUser",
  data() {
    return {
      error: "",
      success: "",
      fname: "",
      lname: "",
      id: "",
      email: "",
      dictionary: {
        custom: {
          fname: {
            required: () => "First name cannot be empty."
          },
          lname: {
            required: () => "Last name cannot be empty."
          },
          id: {
            required: () => "Student ID cannot be empty.",
            min: () => "Student ID must be 8 numbers.",
            max: () => "Student ID must be 8 numbers."
          },
          email: {
            required: () => "Student email cannot be empty.",
            email: () => "Must be a valid email."
          }
        }
      }
    };
  },
  methods: {
    submit() {
      this.$validator.validate().then(res => {
        if (res == true) {
          var body = new FormData();
          body.append("fname", this.fname);
          body.append("lname", this.lname);
          body.append("id", this.id);
          body.append("email", this.email);
          body.append("func", "createUser");
          this.$http
            .post("./back/User.php", body)
            .then(() => {
              this.success = "User account has been created!"
              this.passSuccessMessage();
              this.$router.push("/");
            })
            .catch(error => {
              this.error =
                statusCodeHandler(error.response.status) +
                error.response.data;
              this.passErrorMessage();
            });
        }
      });
    },
    passErrorMessage() {
      this.$emit("pass-error-message", this.error);
    },
    passSuccessMessage() {
      this.$emit("pass-success-message", this.success);
    }
  },
  mounted() {
    this.$validator.localize("en", this.dictionary);
  }
};
</script>

