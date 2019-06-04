Vue.use(VueRouter);
Vue.use(VeeValidate);

const routes = [{
        path: '/',
        component: allSessions
    },
];

const router = new VueRouter({
    base: "~/public_html/SIAttendance/",
    routes // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    next()
})

const app = new Vue({
    el: '#app',
    watch: {},
    data: {
        msg: 'Hello'
    },
    methods: {},
    router
})
