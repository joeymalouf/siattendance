import {AuthorizationService} from './back/AuthorizationService'
import Vue from 'vue'
import App from './src/App'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify/lib'
import VeeValidate from 'vee-validate'

Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(Vuetify)


const routes = [{
    path: '/AllSessions',
    component: allSessions
},
{
    path: '/session/:sessionid',
    component: session,
    beforeRouterEnter () {

    },
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
{
    path: '/leader',
    component: LeaderHome,
    beforeEnter: (to, from, next) => {
        var role = AuthorizationService.checkRole();
        if (role == "leader" || role == "mentor" || role ==  "admin") {
            next()
        }
        next(false)
    },
    children: [
        {
            path: '/home',
            component: LeaderHome
        }
    ]
}
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

new Vue({
    el: '#app',
    components: { App },
    $_veeValidate: {
        validator: 'new'
    },
	vuetify: new Vuetify(),

    watch: {},
    data: {
        errorMessage: '',
        successMessage: '',
	errorShow: false,
	successShow: false,
    },
    methods: {
        clearSuccess () {
            this.successMessage = null
	    this.successShow = false
        },
        clearError () {
            this.errorMessage = null
	    this.errorShow = false
        },
        addError(text) {
            this.errorMessage = text
	    this.errorShow = true
        },
        addSuccess(text) {
            this.successMessage = text
	    this.successShow = true

        }
    },
    router,
    computed: {
        signUp() {
            return this.$route.path === '/createUser';
	}    
},
    mounted() {

	}

})
