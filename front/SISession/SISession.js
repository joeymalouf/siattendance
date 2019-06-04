new Vue.component("session", {
    template: `
    <div id="session">
        {{ session }}
    </div>`,
    data: function () {
        return {
            message: "Hello word",
            session: {},
            qr: {}
        }
    },
    methods: {
        database() {
            var ID = 2;
            console.log(ID)
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
    },
    beforeMount() {
        this.database();
    }
});
