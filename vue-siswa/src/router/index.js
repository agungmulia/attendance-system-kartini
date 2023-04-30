import { createRouter, createWebHistory } from "vue-router";

import store from "../store/index.js";

import Login from "../views/Login.vue";
import DefaultLayout from "../components/DefaultLayout.vue";

import Dashboard from "../views/Dashboard.vue";

import Profil from "../views/Profil.vue";

const routes = [
    {
        path: "/",
        redirect: "/dashboard",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: "/dashboard",
                name: "Dashboard",
                component: Dashboard,
            },
            {
                path: "/profil",
                name: "Profil",
                component: Profil,
            },
        ],
    },

    {
        path: "/login",
        name: "Login",
        meta: { isGuest: true },
        component: Login,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "Login" });
    } else if (store.state.user.token && to.meta.isGuest) {
        next({ name: "Dashboard" });
    } else {
        next();
    }
});
export default router;
