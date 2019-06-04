Vue.use(VueRouter);
Vue.use(VeeValidate);

const routes = [{
        path: '/allSessions',
        component: allSessions
    },
];

const router = new VueRouter({
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
