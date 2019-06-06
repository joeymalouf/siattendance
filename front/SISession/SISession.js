var session = Vue.component("session", {
    template: `
    <v-layout>
    <v-flex xs12 sm6 offset-sm3>
      <v-card id="card">
        <v-card-title primary-title>
          <div>
            <h4>Course: {{ session.course }} </h4>
            <h4>Professor: {{ session.professor }} </h4>
            <h4>Type: {{ session.type }} </h4>
            <h4>Date/Time: {{ session.date_time }} </h4>
          </div>
        </v-card-title>
      </v-card>
      <div id="attendance"></div>
      <v-btn color="orange" v-on:click="viewQR()" id="qrprint">View QR</v-btn></a>
      <v-data-table :headers="headers" :items="attendances" class="elevation-1">
        <template v-slot:items="props">
            <td>{{ props.attendance.fname }} {{ props.attendance.lname }}</td>
            <td>{{ props.attendance.id }}</td>
            <td><router-link :to="'/session/'+props.item.sessionid"  style="text-decoration: none;"><v-btn class="info">View</v-btn></router-link></td>
        </template>
    </v-data-table>
    </v-flex>
    <div id="qrcode" style="display:none"></div>
  </v-layout>`,
    data: function () {
        return {
            message: "Hello word",
            session: {
                sessionid: 2,
                course: "Chem 105",
                type: "Lecture Review",
                professor: "ONeal",
                date_time: "0000-00-00 00:00:00",
            },
            qr: "",
            attendances: [],
        }
    },
    methods: {
        database() {
            var ID = this.$route.params.sessionid;
            new QRCode(document.getElementById("qrcode"), {
                text: "https://turing.cs.olemiss.edu/~jmmalouf/SIAttendence/#/session/" + this.ID,
                width: 512,
                height: 512,
            });
            var body = new FormData();
            body.append('sessionID', ID);
            body.append('func', 'getSession');
            this.$http.post('back/SISession.php', body)
                .then(response => {
                    console.log(response.data)
                    this.session = response.data[0]
                    this.message = "Pass"
                }, response => {
                    this.message = "Fail"
                });
            var attendanceBody = new FormData();
            attendanceBody.append('sessionID', ID);
            attendanceBody.append('func', 'getSessionAttendance');
            this.$http.post('back/SISession.php', body)
                .then(response => {
                    console.log(response.data)
                    this.attendances = response.data[0]
                    this.message = "Pass"
                }, response => {
                    this.message = "Fail"
                });
        },

        viewQR() {
            this.qr = document.getElementById("qrcode").getElementsByTagName("img")[0].src;
            var win = window.open();
            win.document.write('<iframe src="' + this.qr + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; align-content: center; justify-content: center;" allowfullscreen></iframe>');
            win.document.getElementsByTagName('iframe')[0].style.marginLeft = "calc(50vw - 256px)";
            win.document.getElementsByTagName('iframe')[0].style.marginTop = "calc(50vh - 256px)";
        }
    },
    mounted() {
        this.database();
    }
});
