new Vue({
    el: '#session',

    data: {
        message: "Hello word",
    },
    methods: {
        database: function() {
            var ID = 2;
            console.log(ID)
            var result = $.post('SISession.php', {
                sessionID: ID,
                func: 'getSession'
            })
            .done( function () {
                console.log(result)
                this.message = "Pass"
            })
            .fail( function () {
                this.message = "Fail"
            })
        }
    }
});
