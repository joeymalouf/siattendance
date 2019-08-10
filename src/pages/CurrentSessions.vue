    <template>
    <v-flex xs12 sm10 md6>
    <v-data-table :headers="headers" :items="sessions" class="elevation-1">
        <template v-slot:items="props">
            <td class="text-xs-right">{{ props.item.course }}</td>
            <td class="text-xs-right">{{ props.item.professor }}</td>
            <td class="text-xs-right">{{ props.item.type }}</td>
            <td class="text-xs-right">{{ props.item.date_time }}</td>
            <td><v-btn @click="attendSession(props.item.sessionid)" class="info">Sign in</v-btn></td>
        </template>
    </v-data-table>
    </v-flex>
</template>
<script>
export default {
    name: 'CurrentSessions',
    data: function () {
        return {
            message: "",
            sessions: [],
            headers: [
                {
                    text: "Course",
                    sortable: true,
                    value: 'course' 
                },
		{
                    text: "Professor",
                    sortable: true,
                    value: 'professor' 
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
                    text: "",
                    sortable: true,
                    value: 'signin' 
                },
            ],
        }
    },
    methods: {
        database() {
            var body = new FormData()
            body.append('func', 'getCurrentSessions')
            this.$http.post('back/SISession.php', body)
                .then(response => {
                    this.sessions = response.data
                    this.message = "Current Session Pass"
                }).catch(error => {
                    this.message = "Current Session Fail"
                })
        },
        attendSession(ID) {
            this.$router.push('/attendance/' + ID)
        }
    },
    beforeMount() {
        this.database()
    }
}
</script>