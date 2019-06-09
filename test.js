
Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(Vuetify)
const app = new Vue({
    el: '#app',
    data: () => ({
      drawer: null
    }),
  
    props: {
      source: String
    }

  })