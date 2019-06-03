new Vue({
    el: '#session',

    data: {
        message: "Hello word",
    },
    methods: {
        database: function() {
            var ID = 2;
            console.log(ID)
		var body = new FormData();
		body.append('sessionID', ID);
		body.append('func', 'getSession');
            this.$http.post('../../back/SISession.php', body).then((response) => {
                console.log(response.data)
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
