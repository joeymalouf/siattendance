<template>
  <v-flex xs12 sm10 md10>
    <v-data-table
      :headers="headers"
      :items="users"
      sort-by="username"
      :search="search"
      class="elevation-1"
    >
      <template v-slot:item.admin="{ item }">{{ item.admin }}</template>
      <template v-slot:item.leader="{ item }">{{ item.leader }}</template>
      <template v-slot:item.mentor="{ item }">{{ item.mentor }}</template>
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title>Users</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            appendIcon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
          <v-dialog v-model="dialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">{{ editedItem.username }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.fname" label="First Name"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.lname" label="Last Name"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.mi" label="Middle Initial"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.id" label="Student ID"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-checkbox v-model="editedItem.leader" label="Leader"></v-checkbox>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-checkbox v-model="editedItem.mentor" label="Mentor"></v-checkbox>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-checkbox v-model="editedItem.admin" label="Admin"></v-checkbox>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.action="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
  </v-flex>
</template>

<script>
import { statusCodeHandler } from "../handlers/HttpStatusCodeHandler";

export default {
  name: "AllUsers",
  data() {
    return {
      dialog: false,
      error: "",
      success: "",
      search: "",
      editedIndex: -1,
      editedItem: {
        username: "No data",
        fname: "No data",
        lname: "No data",
        mi: "No data",
        id: "No data",
        admin: false,
        mentor: false,
        leader: false,
        email: "No data"
      },
      users: [
        {
          username: "jmmalouf",
          fname: "No data",
          lname: "No data",
          mi: "No data",
          id: "No data",
          admin: false,
          mentor: false,
          leader: false,
          email: "No data"
        },
        {
          username: "No data",
          fname: "No data2",
          lname: "No data2",
          mi: "No data2",
          id: "No data2",
          admin: false,
          mentor: false,
          leader: false,
          email: "No data2"
        },
        {
          username: "jmmblouf",
          fname: "No data3",
          lname: "No data3",
          mi: "No data3",
          id: "No data3",
          admin: false,
          mentor: false,
          leader: false,
          email: "No data3"
        }
      ],
      headers: [
        {
          text: "Username",
          sortable: true,
          value: "username"
        },
        {
          text: "First Name",
          sortable: true,
          value: "fname"
        },
        {
          text: "Last Name",
          sortable: true,
          value: "lname"
        },
        {
          text: "Middle Initial",
          sortable: true,
          value: "mi"
        },
        {
          text: "Student ID",
          sortable: true,
          value: "id"
        },
        {
          text: "Leader",
          sortable: true,
          value: "leader"
        },
        {
          text: "Mentor",
          sortable: true,
          value: "mentor"
        },
        {
          text: "Admin",
          sortable: true,
          value: "admin"
        },
        {
          text: "E-mail",
          sortable: true,
          value: "email"
        },
        {
          text: "Actions",
          value: "action",
          sortable: false
        }
      ]
    };
  },
  methods: {
    database() {
      var body = new FormData();
      body.append("func", "allUsers");
      this.$http
        .post("back/admin.php", body)
        .then(response => {
          this.users = response.data;
        })
        .catch(error => {
          this.error =
            statusCodeHandler(error.response.status) + "Could not find users.";
          this.passErrorMessage();
        });
    },
    editItem(item) {
      this.editedIndex = this.users.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.users.indexOf(item);
      if (confirm("Are you sure you want to delete this user?")) {
          this.users.splice(index, 1);
      }
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      Object.assign(this.users[this.editedIndex], this.editedItem);

      this.close();
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