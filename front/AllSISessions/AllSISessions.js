var allSessions = Vue.component("allSessions", {
    template: `
    <v-data-table :headers="headers" :items="sessions" class="elevation-1">
        <template v-slot:items="props">
            <td>{{ props.item.sessionid }}</td>
            <td class="text-xs-right">{{ props.item.course }}</td>
            <td class="text-xs-right">{{ props.item.type }}</td>
            <td class="text-xs-right">{{ props.item.date_time }}</td>
            <td><button class='btn' v-on:click="viewSession(props.item.sessionid)">View</button></td>
        </template>
    </v-data-table>
            `
            ,
    data: function () {
        return {
            message: "Hello word",
            sessions: [],
            headers: [
                {
                    text: "ID",
                    sortable: true,
                    value: 'id' 
                },
                {
                    text: "Course",
                    sortable: true,
                    value: 'course' 
                },
                {
                    text: "Type",
                    sortable: true,
                    value: 'type' 
                },
                {
                    text: "Date/Time",
                    sortable: true,
                    value: 'date_time' 
                },
                {
                    text: "View",
                    sortable: true,
                    value: 'view' 
                },
            ],
        }
    },
    methods: {
        database() {
            var ID = 2;
            console.log(ID)
            var body = new FormData();
            body.append('func', 'getAllSessions');
            this.$http.post('back/SISession.php', body)
                .then(response => {
                    console.log(response.data)
                    this.sessions = response.data
                    this.message = "All Session Pass"
                }, response => {
                    this.message = "All Session Fail"
                });
        },
        viewSession(ID) {
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
        }
    },
    beforeMount() {
        this.database();
    }
});
