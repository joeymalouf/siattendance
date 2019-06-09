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
                sessionid: 2,
                course: "Chem 105",
                type: "Lecture Review",
                professor: "ONeal",
                date_time: "0000-00-00 00:00:00",
            },
            message: '',
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
                                this.message = "Pass"
                            }, _ => {
                                this.message = "Fail"
                            });
                }, _ => {
                    this.message = "Fail"
                });
        },

    },
    mounted() {
        this.submit();
    },

});
