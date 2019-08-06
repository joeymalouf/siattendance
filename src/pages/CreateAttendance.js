var createAttendance = Vue.component("createAttendance", {
    template: `
    <v-flex xs12 md7>
      <v-card id="card">
        <v-card-title primary-title style="margin-bottom: 20px" class="elevation-2">
          <div>
            <h4>Course: {{ session.course }} </h4>
            <h4>Professor: {{ session.professor }} </h4>
            <h4>Type: {{ session.type }} </h4>
            <h4>Date/Time: {{ session.date_time }} </h4>
          </div>
        </v-card-title>
      </v-card>
    </v-flex>`,
    data: function () {
        return {
            sessionid: this.$route.params.sessionid,
            session: {
                sessionid: 0,
                course: "Session not found",
                type: "Session not found",
                professor: "Session not found",
                date_time: "Session not found",
            },
            error: "",
            success: "",
        }
    },
    methods: {
        submit() {
            var attendanceBody = new FormData();
            attendanceBody.append('sessionID', this.sessionid);
            attendanceBody.append('func', 'createAttendance');
            this.$http.post('back/Attendance.php', attendanceBody)
                .then(response => {
                        var sessionBody = new FormData();
                        sessionBody.append('sessionID', this.sessionid);
                        sessionBody.append('func', 'getSession');
                        this.$http.post('back/SISession.php', sessionBody)
                            .then(response => {
                                this.session = response.data[0]
                                this.success = "You've been added to the session."
                                this.passSuccessMessage();
                            }, _ => {
                                this.error = "Could not retrieve session data from server."
                                this.passErrorMessage();
                            });
                }, _ => {
                    this.error = "Could not find session. Try again or contact SI leader."
                    this.passErrorMessage();
                });
        },
        passErrorMessage() {
            this.$emit('pass-error-message', this.error)
        },
        passSuccessMessage() {
            this.$emit('pass-success-message', this.success)
        },
    },
    mounted() {
        this.submit();
    },

});
