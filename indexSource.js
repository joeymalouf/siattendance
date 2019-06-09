Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(Vuetify)

const routes = [{
    path: '/',
    component: allSessions
},
{
    path: '/session/:sessionid',
    component: session
},
{
    path: '/createUser',
    component: createUser
},
];

const router = new VueRouter({
    base: "~/public_html/SIAttendance/",
    routes // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    if (true) {
        next();
    }
    next(false);
})

const app = new Vue({
    el: '#app',
    $_veeValidate: {
        validator: 'new'
    },
    watch: {},
    data: () => ({
        drawer: null
      }),
    methods: {},
    router,
    computed: {
        signUp() {
            return this.$route.path === '/createUser';
        }
    }
})
