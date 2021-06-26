/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.Vue = require('vue').default;


import 'bootstrap/dist/css/bootstrap.css';


import axios from 'axios';

// importing custom css file
require('../css/style.css');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import App from './components/App.vue';


// datatable global registration
import { VuejsDatatableFactory } from 'vuejs-datatable';
Vue.use( VuejsDatatableFactory );

// import layouts
import DefaultLayout from './layouts/DefaultLayout';
Vue.component('default-layout',DefaultLayout);

// import router for use in vue instance
import router from './routes/index';



// set router middleware for the all pages
router.beforeEach((to,form,next)=>{
    if(to.meta.requiresAuth){
        if(localStorage.getItem("Token") == null){
            next({
                name: "userlogin",
            });
            
        }else{
            next();
        }
    }else if(to.meta.guest){
        if(localStorage.getItem("Token") != null){
           next({
               name: "createmployee",
           })
        }else{
            next();
        }
    }else{
        next();
    }
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
     el: '#app',
    components: {
        App
    },
    router,
    render: h => h(App)
});
