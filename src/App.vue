<template>
  <v-app id="inspire">
    <!--<v-toolbar app dark color="#14213d" fixed v-if="!signUp">
                <v-toolbar-side-icon></v-toolbar-side-icon>
                <v-toolbar-title>SI Attendance</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items class="hidden-sm-and-down">
                    <v-btn flat>Link One</v-btn>
                    <v-btn flat>Link Two</v-btn>
                    <v-btn flat>Link Three</v-btn>
                </v-toolbar-items>
            </v-toolbar>
    -->
    <v-app-bar app color="#14213d" dark>
      <v-toolbar-title>SI Attendance</v-toolbar-title>
    </v-app-bar>
    <v-content>
      <v-container fluid :style="[!signUp ? {'height': '100%'} : {'height' : '100vh'}]">
        <v-layout row justify-center wrap>
          <v-flex xs12 sm11 md7 style="margin-bottom: 15px;" align-start>
            <v-alert :value="successShow" type="success">
              {{ successMessage }}
              <a style="float: right" v-on:click="clearSuccess()">
                <v-icon>mdi-close-circle</v-icon>
              </a>
            </v-alert>
          </v-flex>
          <v-flex xs12 sm11 md7 style="margin-bottom: 15px;" align-start>
            <div>
              <v-alert :value="errorShow" type="error">
                {{ errorMessage }}
                <a style="float: right" v-on:click="clearError()">
                  <v-icon>mdi-close-circle</v-icon>
                </a>
              </v-alert>
            </div>
          </v-flex>
          <router-view v-on:pass-error-message="addError" v-on:pass-success-message="addSuccess"></router-view>
        </v-layout>
      </v-container>
    </v-content>
    <v-footer app dark color="#14213d" inset v-if="!signUp">
      <span class="white--text">&copy; 2017</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: "App",
  components: {},
  data() {
    return {
      errorMessage: "",
      successMessage: "",
      errorShow: false,
      successShow: false
    };
  },
  methods: {
    clearSuccess() {
      this.successMessage = null;
      this.successShow = false;
    },
    clearError() {
      this.errorMessage = null;
      this.errorShow = false;
    },
    addError(text) {
      this.errorMessage = text;
      this.errorShow = true;
    },
    addSuccess(text) {
      this.successMessage = text;
      this.successShow = true;
    }
  },
  computed: {
    signUp() {
      return this.$route.path === "/createUser";
    }
  },
  mounted() {

  }
};
</script>
