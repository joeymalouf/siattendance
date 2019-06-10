Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(Vuetify)

const routes = [{
    path: '/AllSessions',
    component: allSessions
},
{
    path: '/session/:sessionid',
    component: session
},
{
    path: '/attendance/:sessionid',
    component: createAttendance
},
{
    path: '/',
    component: currentSessions
},
{
    path: '/createUser',
    component: createUser
},
{
    path: '/createSession',
    component: createSession
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
    data: {
        errorMessage: '',
        successMessage: '',
    },
    methods: {
        clearSuccess () {
            this.successMessage = null

        },
        clearError () {
            this.errorMessage = null
        },
        addError(text) {
            this.errorMessage = text
        },
        addSuccess(text) {
            this.successMessage = text

        }
    },
    router,
    computed: {
        signUp() {
            return this.$route.path === '/createUser';
        }
    }
})
