<template>
  <v-flex xs12 sm10 md6>
    <v-data-table :headers="headers" :items="sessions" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.sessionid }}</td>
        <td class="text-xs-right">{{ props.item.course }}</td>
        <td class="text-xs-right">{{ props.item.professor }}</td>
        <td class="text-xs-right">{{ props.item.type }}</td>
        <td class="text-xs-right">{{ props.item.date_time }}</td>
        <td>
          <router-link :to="'/session/'+props.item.sessionid" style="text-decoration: none;">
            <v-btn class="info">View</v-btn>
          </router-link>
        </td>
      </template>
    </v-data-table>
  </v-flex>
</template>
<script>
export default {
  name: "AllSessions",
  data() {
    return {
      message: "Hello word",
      sessions: [],
      headers: [
        {
          text: "ID",
          sortable: true,
          value: "id"
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
      ]
    }
  },
  methods: {
    database() {
      var ID = 2
      console.log(ID)
      var body = new FormData()
      body.append("func", "getAllSessions")
      this.$http
        .post("./back/SISession.php", body)
        .then(response => {
          console.log(response.data)
          this.sessions = response.data
          this.message = "All Session Pass"
        })
        .catch(error => {
          console.log(error)
          this.message = "All Session Fail"
        })
    }
  },
  beforeMount() {
    this.database()
  }
}
</script>