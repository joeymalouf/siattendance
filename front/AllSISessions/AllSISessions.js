new Vue({
    el: '#sessions',

    data: {
        message: "Hello word",
        sessions: {},
    },
    methods: {
        database: function() {
            var ID = 2;
            console.log(ID)
		var body = new FormData();
		body.append('func', 'getAllSessions');
            this.$http.post('../../back/SISession.php', body)
            .then( response => {
                console.log(response.data)
                sessions = response.data
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
