import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: routes,
    scrollBehavior(to, from, savedPosition){
        if (savedPosition) {
        return savedPosition;
        }
    }
})



export default router;