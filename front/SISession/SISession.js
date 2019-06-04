var session = Vue.component("session", {
    template: `
    <div id="session">
        {{ session }}
	<div id="qrcode"></div>
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
            var ID = this.$route.params.sessionid;
            var body = new FormData();
            body.append('sessionID', ID);
            body.append('func', 'getSession');
            this.$http.post('back/SISession.php', body)
                .then(response => {
                    console.log(response.data)
                    this.session = response.data[0]
		    new QRCode(document.getElementById("qrcode"), "https://turing.cs.olemiss.edu/~jmmalouf/SIAttendence/#/session/"+this.session.sessionid);
                    this.message = "Pass"
                }, response => {
                    this.message = "Fail"
                });
        }
    },
    mounted() {
        this.database();
    }
});
