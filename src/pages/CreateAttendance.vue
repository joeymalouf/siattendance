<template>
  <v-flex xs12 sm11 md7>
    <v-card id="card">
      <v-card-title primary-title style="margin-bottom: 20px" class="elevation-2">
        <div>
          <b>Course: </b>{{ session.course }}
          <h4>Professor: </h4>{{ session.professor }}
          <h4>Type: </h4>{{ session.type }}
          <h4>Date/Time: </h4>{{ session.date_time }}
        </div>
      </v-card-title>
    </v-card>
  </v-flex>
</template>
<script>
export default {
  name: "CreateAttendance",
  data() {
    return {
      sessionid: this.$route.params.sessionid,
      session: {
        sessionid: 0,
        course: "Session not found",
        type: "Session not found",
        professor: "Session not found",
        date_time: "Session not found"
      },
      error: "",
      success: "",
    }
  },
  methods: {
    submit() {
      var attendanceBody = new FormData()
      attendanceBody.append("sessionID", this.sessionid)
      attendanceBody.append("func", "createAttendance")
      this.$http
        .post("back/Attendance.php", attendanceBody)
        .then(response => {
          var sessionBody = new FormData()
          sessionBody.append("sessionID", this.sessionid)
          sessionBody.append("func", "getSession")
          this.$http
            .post("back/SISession.php", sessionBody)
            .then(response => {
              this.session = response.data[0]
              this.success = "You've been added to the session."
              this.passSuccessMessage()
            })
            .catch(error => {
              this.error = "Could not retrieve session data from server."
              this.passErrorMessage()
            })
        })
        .catch(error => {
          this.error =
            "Could not find session. Session ID in URL ( "+ this.sessionid +" ) may be incorrect"
          this.passErrorMessage()
        })
    },
    passErrorMessage() {
      this.$emit("pass-error-message", this.error)
    },
    passSuccessMessage() {
      this.$emit("pass-success-message", this.success)
    }
  },
  mounted() {
    this.submit()
  }
}
</script>