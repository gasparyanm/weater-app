import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";

import WeatherIndex from "../views/weather/Index"

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "WeatherIndex",
        component: WeatherIndex,
    },
];

const router = new VueRouter({
    history:true,
    mode: "history",
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (store.getters.isAuthenticated) {
            next();
            return;
        }
        next("/login");
    } else {
        next();
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.guest)) {
        if (store.getters.isAuthenticated) {
            next("/");
            return;
        }
        next();
    } else {
        next();
    }
});

export default router;
