<template>
  <v-flex xs12 md7>
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
    <div id="attendance"></div>
    <v-data-table
      :headers="headers"
      :items="attendances"
      class="elevation-2"
      style="margin-bottom: 10px"
    >
      <template v-slot:items="props">
        <td>{{ props.item.fname }} {{ props.item.lname }}</td>
        <td>{{ props.item.id }}</td>
      </template>
    </v-data-table>
    <v-btn color="orange" v-on:click="viewQR()" id="qrprint">View QR</v-btn>
    <div id="qrcode" style="display:none"></div>
  </v-flex>
</template>
<script>
import QRCode from "qrcodejs2";

export default {
  name: "Session",
  data: function() {
    return {
      message: "Hello word",
      session: {
        sessionid: 2,
        course: "Chem 105",
        type: "Lecture Review",
        professor: "ONeal",
        date_time: "0000-00-00 00:00:00",
        polling: null
      },
      qr: "",
      attendances: [
        // {
        //     fname: "j",
        //     lname: "m",
        //     id: "100"
        // },
        // {
        //     fname: "j",
        //     lname: "m",
        //     id: "101"
        // },
      ],
      headers: [
        {
          text: "Name",
          sortable: true,
          value: "name"
        },
        {
          text: "Student ID",
          sortable: true,
          value: "id"
        }
      ]
    };
  },
  methods: {
    database() {
      var ID = this.$route.params.sessionid;
      var body = new FormData();
      body.append("sessionID", ID);
      body.append("func", "getSession");
      this.$http
        .post("back/SISession.php", body)
        .then(response => {
          this.session = response.data[0];
          this.message = "Pass";
        })
        .catch(error => {
          this.message = "Fail";
        });

      var attendanceBody = new FormData();
      attendanceBody.append("sessionID", ID);
      attendanceBody.append("func", "getSessionAttendance");
      this.$http
        .post("back/SISession.php", attendanceBody)
        .then(response => {
          this.attendances = response.data;
          this.message = "Pass";
        })
        .catch(error => {
          this.message = "Fail";
        });
    },
    viewQR() {
      this.qr = document
        .getElementById("qrcode")
        .getElementsByTagName("img")[0].src;
      var test =
        "data:text/html;charset=utf-8," +
        encodeURI(
          '<div style="display: table-cell;height: 95vh;text-align: center;width: 100vw;vertical-align: middle;"><img src="' +
            this.qr +
            '"></div>'
        );
      var win = window.open();
      win.document.write(
        '<iframe src="' +
          test +
          '" frameborder="0" style="width:100%; height:100%;" allowfullscreen></iframe>'
      );
    }
  },
  mounted() {
    var ID = this.$route.params.sessionid;
    new QRCode(document.getElementById("qrcode"), {
      text:
        "https://turing.cs.olemiss.edu/~jlucas/test/SIAttendance/back/yup.php?sessionid=" +
        ID,
      width: 512,
      height: 512
    });
    this.database();
    this.$nextTick(function() {
      window.setInterval(() => {
        this.database();
      }, 5000);
    });
  }
};
</script>