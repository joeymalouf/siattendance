<template>
  <v-flex xs12 sm11 md7>
    <v-card id="card">
      <v-card-title primary-title style="margin-bottom: 20px" class="elevation-2">
        <div>
          <h4>Course: {{ session.course }}</h4>
          <h4>Professor: {{ session.professor }}</h4>
          <h4>Type: {{ session.type }}</h4>
          <h4>Date/Time: {{ session.date_time }}</h4>
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
      success: ""
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
          console.log(response)
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
              console.log(error)
            })
        })
        .catch(error => {
          this.error =
            "Could not find session. Try again or contact SI leader."
          this.passErrorMessage()
          console.log(error)
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