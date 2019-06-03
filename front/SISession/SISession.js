new Vue({
    el: '#session',

    data: {
        message: "Hello word",
    },
    post: {
        database: function () {
            var ID = 2;
            console.log(ID)
            var result = $.post('SISession.php', {
                sessionID: ID,
                func: 'getSession'
            })
            .done(function () {
                console.log(result)
                data = "Pass"
            })
            .fail(function () {
                data = "Fail"
            })
        }
    }

})
