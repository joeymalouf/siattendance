<template>
  <v-flex xs12 sm10 md6>
    <v-data-table :headers="headers" :items="sessions" class="elevation-1">
      <template v-slot:item.view="{ item }">
        <router-link :to="'/session/'+ item.sessionid " style="text-decoration: none;">
          <v-btn class="info">View</v-btn>
        </router-link>
      </template>
    </v-data-table>
  </v-flex>
</template>
<script>
import { statusCodeHandler } from '../handlers/HttpStatusCodeHandler'

export default {
  name: "AllSessions",
  data() {
    return {
      sessions: [
        {
          course: "No data",
          type: "No data",
          date_time: "No data",
          sessionid: "No data",
          professor: "No data"
        },
        {
          course: "No data",
          type: "No data",
          date_time: "No data",
          sessionid: "No data",
          professor: "No data"
        }
      ],
      headers: [
        {
          text: "ID",
          sortable: true,
          value: "sessionid"
        },
        {
          text: "Course",
          sortable: true,
          value: "course"
        },
        {
          text: "Professor",
          sortable: true,
          value: "professor"
        },
        {
          text: "Type",
          sortable: true,
          value: "type"
        },
        {
          text: "Date/Time",
          sortable: true,
          value: "date_time"
        },
        {
          text: "",
          sortable: true,
          value: "view"
        }
      ],
      error: "",
      success: "",
    }
  },
  methods: {
    database() {
      var body = new FormData();
      body.append("func", "getAllSessions");
      this.$http
        .post("./back/SISession.php", body)
        .then(response => {
          this.sessions = response.data;
        })
        .catch(error => {
          this.error = statusCodeHandler(error.response.status) + "Could not find sessions."
          this.passErrorMessage()
        });
    },
    passErrorMessage() {
      this.$emit("pass-error-message", this.error);
    },
    passSuccessMessage() {
      this.$emit("pass-success-message", this.success);
    }
  },
  beforeMount() {
    this.database();
  }
};
</script>