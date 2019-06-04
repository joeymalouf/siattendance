var allSessions = Vue.component("allSessions", {
    template: `<div class="container">
    <div class="row col-sm-10">
        <div id="sessions">
            <table class='table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Professor</th>
                        <th>Course</th>
                        <th>Type</th>
                        <th>Date/Time</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in sessions">
                        <td>{{ row.sessionid }}</td>
                        <td>{{ row.professor }}</td>
                        <td>{{ row.course }}</td>
                        <td>{{ row.type }}</td>
                        <td>{{ row.date_time }}</td>
                        <td><button class='btn' v-on:click="viewSession(row.sessionid)">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>`,
    data: function ()  {
        return {
            message: "Hello word",
            sessions: {},
        }
    },
    methods: {
        database() {
            var ID = 2;
            console.log(ID)
            var body = new FormData();
            body.append('func', 'getAllSessions');
            this.$http.post('../../back/SISession.php', body)
                .then(response => {
                    console.log(response.data)
                    this.sessions = response.data
                    this.message = "Pass"
                }, response => {
                    this.message = "Fail"
                });
        },
        viewSession(ID) {
            var body = new FormData();
            body.append('sessionID', ID);
            body.append('func', 'getSession');
            this.$http.post('../../back/SISession.php', body)
                .then(response => {
                    console.log(response.data)
                    this.session = response.data[0]
                    this.message = "Pass"
                }, response => {
                    this.message = "Fail"
                });
        }
    }
});
